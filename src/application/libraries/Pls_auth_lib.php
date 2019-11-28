<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Authenticaton and Authorization Library
 *
 * @author     Alijon alijonshukurov@gmail.com
 * @author     bzimor <bobzimor@gmail.com>
 * @version    2.5
 */
class Pls_auth_lib
{

    /**
     * Variable for loading the config array into
     * @access public
     * @var array
     */
    public $auth_config;

    public $max_login_attempt;

    public $attempt_time_interval;


    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();

        // config/auth.php
        $this->CI->config->load('auth');
        $this->auth_config = $this->CI->config->item('auth');
        $this->max_login_attempt = $this->CI->config->item('max_login_attempt');
        $this->attempt_time_interval = $this->CI->config->item('attempt_time_interval');
    }

    /*==========================================================================
    |                              AUTHENTICATION
    |==========================================================================*/
    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return bool Indicates successful login.
     */
    public function login($email, $password)
    {
        if (! $this->check_access_attempts('login', $email)) {
            return FALSE;
        }
        //clears previous errors
        $this->CI->pls_alert_lib->clear_messages();
        //attemps data
        $attempts_data = ['status' => LOGIN_ATTEMPS_STATUS_FAILED];
        $attempts_data['email'] = $email;
        $attempts_data['action'] = 'login';
        //get user by email
        if ($user = $this->get_user_by(['email' => $email])) {
            $fields = array(
                'email' => $email,
                'password' => $this->hash_password($password, $user->user_id),
                'status !=' => STATUS_DRAFT,
                'is_deleted' => 0
            );
            //verify password
            if ($this->CI->users_model->exists($fields)) {
                if ($user->status == STATUS_INACTIVE) {
                    return STATUS_INACTIVE;
                }
                //update session userdata
                $this->update_session_userdata($user);

                //attemps data
                $attemps_data['status'] = LOGIN_ATTEMPS_STATUS_SUCCESS;
                $attemps_data['user_id'] = $user->user_id;
                $result = TRUE;
            } else {
                $result = FALSE;
            }
        } else {
            $result = FALSE;
        }
        //save access attempts
        $this->log_access_attempts($attempts_data);

        return $result;
    }


    /**
     * Check user login
     * @return bool
     */
    public function is_loggedin()
    {
        if ($this->CI->session->userdata('loggedin')) {
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Logout user
     * Destroys the CodeIgniter session and remove cookies to log out user.
     * @return bool If session destroy successful
     */
    public function logout()
    {
        return $this->CI->session->sess_destroy();
    }


    /**
    * Sign up
    * @param array $data
    * @return bool Indicates successful sign up.
    */
    public function sign_up($user_data)
    {
        //clears previous alert messages
        $this->CI->pls_alert_lib->clear_messages();
        //save raw password string to variable
        $old_password = $user_data['password'];
        // Password cannot be blank but user_id required for salt, setting bad password for now
        $user_data['password'] = $this->hash_password($user_data['password'], 0);
        // $user_data['status'] = USER_STATUS_NOT_VERIFIED;
        if ($user_id = $this->CI->users_model->save($user_data)) {
            // Update to correct salted password
            $data = array('user_id' => $user_id);
            $data['password'] = $this->hash_password($old_password, $user_id);
            return $this->CI->users_model->save($data);
        }
        return FALSE;
    }


    /**
    * Send email verification link
    * Sends a verification link to verify user's email
    * @param string $email User email to send verification email to
    */
    public function send_email_verification($email)
    {
        if ($user = $this->get_user_by(['email' => $email])) {

            //get generated verification code
            $code = $this->generate_verification_code($email);
            // Update verification_code
            $data = array(
                'user_id' => $user->user_id,
                'verification_code' => $code
            );
            $this->CI->users_model->save($data);

            //send email to user
            $email_ver_link = $this->auth_config['email_verification_link'];
            $email_data['web_site'] = base_url();
            $email_data['full_name'] = $user->first_name.' '.$user->last_name;
            $email_data['verification_link'] = site_url() . $email_ver_link . $code;
            return $this->CI->pls_email_lib->send_email($user->email, $template = 'email_verification', $email_data);
        }
        return FALSE;
    }


    /**
     * Remind password
     * Emails user with link to reset password
     * @param string $email Email for account to remind
     * @return bool Remind fails/succeeds
     */
    public function remind_password($email)
    {
        if (! $this->check_access_attempts('forgot_password', $email)) {
            return FALSE;
        }
        //attempts data
        $attempts_data = ['status' => LOGIN_ATTEMPS_STATUS_FAILED];
        $attempts_data['email'] = $email;
        $attempts_data['action'] = 'forgot_password';

        if ($user = $this->get_user_by(['email' => $email])) {
            //get generated verification code
            $code = $this->generate_verification_code($email);
            // Update verification_code
            $data = array(
                'user_id' => $user->user_id,
                'verification_code' => $code
            );
            $this->CI->users_model->save($data);
            //send email to user
            if ($this->is_admin($user->user_id)) {
                $reset_password_link = $this->auth_config['admin_reset_password_link'];
            }
            else {
                $reset_password_link = $this->auth_config['reset_password_link'];
            }
            $email_data['web_site'] = base_url();
            $email_data['reset_password_link'] = site_url() . $reset_password_link . $code;
            if($this->CI->pls_email_lib->send_email($user->email, $template = 'remind_password', $email_data)){
                //attempts data
                $attempts_data['status'] = LOGIN_ATTEMPS_STATUS_SUCCESS;
                $attempts_data['user_id'] = $user->user_id;
                $this->log_access_attempts($attempts_data);

                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        $this->log_access_attempts($attempts_data);
        return FALSE;
    }


    /**
    * Verify user
    * Check user account based on verification code
    * @param string $ver_code Code to validate against
    * @param bool $signup If this is for email confirmation, send status to user's email
    * @return bool Activation fails/succeeds
    */
    public function verify_user($ver_code, $signup = FALSE)
    {
        //get user by verification code
        if ($user = $this->get_user_by(['verification_code' => $ver_code])) {
            //send email
            if ($signup) {
                //update password and user status
                $data = array(
                    'user_id' => $user->user_id,
                    'verification_code' => '',
                    'status' => USER_STATUS_ACTIVE
                );
                $this->CI->users_model->save($data);
                return $this->CI->pls_email_lib->send_email($user->email, $template = 'email_verified', $email_data = []);
            }
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Reset password
     * @param string $ver_code Verification code for account
     * @param string $password Password for account
     * @return bool Password reset fails/succeeds
     */
    public function reset_password($ver_code, $password)
    {
        //get user by verification code
        if ($user = $this->get_user_by(['verification_code' => $ver_code])) {
            //update password and verification code
            $data = array(
                'user_id' => $user->user_id,
                'verification_code' => '',
                'password' => $this->hash_password($password, $user->user_id)
            );
            if ($this->CI->users_model->save($data)) {
                //send email, it returns TRUE if mail is sent
                $this->CI->pls_email_lib->send_email($user->email, $template = 'password_changed', $email_data = []);
                return TRUE;
            }
        }
        return FALSE;
    }


    /*==========================================================================
    |                ACCESS ATTEMPT(ANTI BRUTEFORCE) OPERATIONS
    |==========================================================================*/

    /**
     * Check access attempts
     */
    public function check_access_attempts($action, $email)
    {
        $last_log = $this->get_last_attempt($action, $email);
        if ($last_log && ! $last_log['status']) {
            $last_log_time =  time() - strtotime($last_log['created_at']);
            if ($last_log_time < $this->attempt_time_interval && $last_log['attempts'] >= $this->max_login_attempt) {
                $this->CI->pls_alert_lib->set_flash_messages('error', lang('auth_login_attempts_exceeded'));
                return FALSE;
            }

        }
        return TRUE;
    }


    /**
     * Log access attempts
     */
    public function log_access_attempts($data)
    {
        $data['ip'] = $this->CI->input->ip_address();
        $data['user_agent'] = $this->CI->agent->agent_string();
        if ($last_log = $this->get_last_attempt($data['action'], $data['email'])) {
            $last_log_time =  time() - strtotime($last_log['created_at']);
            if (!$last_log['status'] && $last_log_time < $this->attempt_time_interval) {
                if ($last_log['attempts'] == ($this->max_login_attempt - 1) && !$data['status']) {
                    $this->CI->pls_alert_lib->set_flash_messages('error', lang('auth_login_attempts_exceeded'));
                }
                elseif ($last_log['attempts'] > 13 && !$data['status']) {
                    $attempts_left = $this->max_login_attempt - $last_log['attempts'] - 1;
                    $warning_message = str_replace('{number}', $attempts_left, lang('auth_login_attempts_left'));
                    $this->CI->pls_alert_lib->set_flash_messages('error', $warning_message);
                }

                $data['attempts'] = $last_log['attempts'] + 1;
            }
        }
        return $this->CI->db->insert('pls_users_access_attempts', $data);
    }


    /**
     * Get last attempt
     */
    public function get_last_attempt($action, $email = NULL)
    {
        $this->CI->db->where(['action' => $action]);
        if ($email) {
            $this->CI->db->where(['email' => $email]);
        }
        else {
            $this->CI->db->where(['ip' => $this->CI->input->ip_address()]);
        }
        $this->CI->db->order_by('user_attemp_id', 'DESC');
        return $this->CI->db->get('pls_users_access_attempts')->row_array();
    }


    /*==========================================================================
    |                              USER RELATED OPERATIONS
    |==========================================================================*/

    /**
    * Get user by
    * Gets user by providing user data
    * @param array User array data e.g. 'email'=>email@mail.com
    * @return object|bool If user existe user return object else false
    */
    public function get_user_by($options)
    {
        return $this->CI->users_model->get_user_by($options);
    }


    /**
    * Update verification code
    * Updates verification code in users table
    * @param string $data User's data to generate unique verification_code
    */
    public function generate_verification_code($data)
    {
        $code = sha1(time().$data);
        return $code;
    }


    /**
     * Hash password
     * @param string $password Password to hash
     * @param $user_id
     * @return string Hashed password
     */
    public function hash_password($password, $user_id)
    {
        $salt = sha1($user_id);
        return sha1($salt . $password);
    }


    /**
     * Update session userdata based on user info
     */
    public function update_session_userdata($user = FALSE)
    {

        if (! $user) {
            $user_id = $this->CI->session->userdata('user')->user_id;
            $user = $this->get_user_by(['user_id' => $user_id]);
        }

        $data = array(
            'user' => $this->CI->users_model->get_full_user_info_by_id($user->user_id, $user->user_role_id == USER_ROLE_ADMINISTRATOR),
            'loggedin' => TRUE,
        );

        $this->CI->session->set_userdata($data);
    }

    /*==========================================================================
    |                              AUTHORIZATION
    |==========================================================================*/

    /**
     * Has user access?
     * Check if user has access to do specific action
     * @param int $permission Permission name to check
     * @param int|bool $user_id User id to check, or if FALSE checks current user
     * @return bool
     */
    public function has_access($permission, $user_id = FALSE)
    {
        if ($user_id == FALSE) {
            if (!$this->is_loggedin()) {
                return FALSE;
            }
            $user_id = $this->CI->session->userdata('user')->user_id;
        }
        $user_group_id = $this->CI->usergroups_model->get_user_group_id($user_id);
        if (!$user_group_id) {
            return FALSE;
        }
        return $this->is_group_allowed($permission, $user_group_id);
    }


    /**
     * Get user permission array
     * @return array
     */
    public function user_permissions()
    {
        if ($this->is_loggedin()) {
            $group_id = $this->CI->session->userdata('user')->group_id;
            $perms = $this->CI->usergroups_model->get_group_perms($group_id);
            if (!$perms) {
                return FALSE;
            }
            return $perms;
        }
        return FALSE;
    }


    /**
     * Is Group allowed
     * Check if group is allowed to do specified action, admin always allowed
     * @param int $permission Permission id to check
     * @param int|string|bool $group_par Group id or name to check, or if FALSE checks all user groups
     * @return bool
     */
    public function is_group_allowed($permission, $group_id = NONE)
    {
        //get permission id
        $permission_id = $this->CI->usergroups_model->get_permission_id_by_name($permission);
        if (!$permission_id){
            return FALSE;
        }
        // if $group_id is given
        if (!$group_id) {
            // if is not login
            if (!$this->is_loggedin()) {
                return FALSE;
            }
            $user_id = $this->CI->session->userdata('user')->user_id;
            $user_group = $this->CI->usergroups_model->get_user_group_id($user_id);
            if (!$user_group) {
                return FALSE;
            }
            $group_id = $user_group->user_group_id;
        }
        return $this->CI->usergroups_model->has_group_permission($group_id, $permission_id);
    }


    /**
    * Is user admin
    * @param int $role_id Role id
    * @param int $user_id User id
    * @return boolean
    */
    public function is_admin($user_id = False)
    {
        // if user is loggedin
        if ($this->is_loggedin() && !$user_id) {
            $user_id = $this->CI->session->userdata('user')->user_id;
        }
        if ($user_id && $user = $this->get_user_by(['user_id' => $user_id])) {
            return $user->user_role_id == USER_ROLE_ADMINISTRATOR;
        }
        return FALSE;
    }
}
