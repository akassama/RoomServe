<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends PLS_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('auth', $this->lang->get_current_lang());
    }


        /**
	* Member signup
	*/
    public function signup()
    {
        $last_access_log = $this->pls_auth_lib->get_last_attempt('signup');
        if($post = $this->input->post(NULL, TRUE)) {
            $attempts_data['email'] = $post['form']['email'];
            $attempts_data['action'] = 'signup';
            if (TRUE) {
                $fields = ['first_name', 'last_name', 'email', 'password', 'confirm_password'];
                $additional_rules = [
                    'email' => ['is_unique'],
                    // 'password' => ['is_valid_password_length'],
                ];
                
                if ($userdata = $this->pls_validation_lib->validate('user', $post['form'], $fields, $additional_rules)) {
                    unset($userdata['confirm_password']);
                    $userdata['user_role_id'] = 2;
                    $userdata['status'] = 1;
                                      
                    if ($user_id = $this->pls_auth_lib->sign_up($userdata)) {
                        // log_activity($user_id, NULL, TRUE, 'members');
                        
                        $attempts_data['status'] = LOGIN_ATTEMPS_STATUS_SUCCESS;
                        $attempts_data['user_id'] = $user_id;
                        //set invitation code as used
                        if (isset($post['form']['invitation_code']) && $post['form']['invitation_code'])   $this->invitation_codes_model->set_code_used($user_id, $post['form']['invitation_code']);
                        if (TRUE) {//if ($this->pls_auth_lib->send_email_verification($userdata['email'])) {
                            $this->pls_alert_lib->set_flash_messages('success', lang('auth_verification_send_success'));
                            $json['redirect'] = '/auth/login';
                        }
                        else {
                            $this->pls_alert_lib->set_flash_messages('error', lang('auth_verification_send_failed'));
                            $json['redirect'] = '/auth/login';
                        }
                    }
                    else{
                        $json['message'] = ajax_messages('error', lang('auth_signup_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
            }
            else {
                $json['validation'] = validation_messages();
            }
            $this->pls_auth_lib->log_access_attempts($attempts_data);
            // if ($show_captcha && !isset($post['g-recaptcha-response']) && !isset($attempts_data['status'])) {
            //     $json['redirect'] = '/member/auth/signup';
            // }
            echo json_encode($json);
        }
        else {
            if ($this->pls_auth_lib->is_loggedin()) {
                redirect(get_previous_url());
            }
            $data['page_type'] = 'sign_up';
            $data['page_title'] = lang('form_sign_up');
            $this->pls_layout_lib->auth_layout('/auth/signup', $data);
        }
    }


    
    /**
    * Member password check callback
    */
    public function _password_validate_length($str)
    {
        if ($str) {
            if (strlen($str) < 5) {
                $this->form_validation->set_message('_password_validate_length', lang('validation_password_length_error'));
                return FALSE;
            }
            return TRUE;
        }
    }

    /**
    * Admin and partner admin login
    */
    public function login()
    {
        //if user is logged and is admin, then redirect to dashboard
        if ($this->pls_auth_lib->is_loggedin()) {
            redirect(get_previous_url($this->pls_auth_lib->is_admin()));
        }
        if($post = $this->input->post(NULL, TRUE)) {
            $fields = array('email', 'password');
            if ($this->pls_validation_lib->validate('user', $post['form'], $fields)) {
                if ($result = $this->pls_auth_lib->login($post['form']['email'], $post['form']['password'])) {
                    $is_admin = $this->pls_auth_lib->is_admin();
                    $this->user = $this->session->userdata('user');
                    $json['redirect'] = get_previous_url($is_admin);
                }
                elseif ($result === STATUS_INACTIVE) {
                    $json['message'] = ajax_messages('warning', lang('auth_login_profile_inactive'));
                }
                else {
                    $message = lang('auth_login_failed');
                    $flash_message = flash_messages('error');
                    if ($flash_message) $message = $flash_message;
                    $json['message'] = ajax_messages('error', $message);
                }
            }
            else{
                $json['validation'] = validation_messages();
            }
            echo json_encode($json);
        }
        else {
            $data['page_title'] = lang('form_sign_in');
            $this->pls_layout_lib->auth_layout('/auth/login', $data);
        }
    }


        /**
    * Member verify email
    */
    public function verify($code = NULL)
    {
        if($code) {
            if ($this->pls_auth_lib->verify_user($code, TRUE)){
                $this->pls_alert_lib->set_flash_messages('success', lang('auth_email_verification_success'));
                redirect('/member/auth/verify_result?success=1');
            }
            else {
                $this->pls_alert_lib->set_flash_messages('error', lang('auth_email_verification_failed'));
                redirect('/member/auth/verify_result?success=0');
            }
        }
        else {
            show_404();
        }
    }


    /**
    * Admin and partner admin forgot password
    */
    public function forgot_password()
    {
        if($post = $this->input->post(NULL, TRUE)) {
            if ($this->pls_validation_lib->validate('user', $post['form'], 'email')) {
                if ($this->pls_auth_lib->remind_password($post['form']['email'])) {
                    $this->pls_alert_lib->set_flash_messages('success', lang('auth_reset_link_send_success'));
                    $json['redirect'] = '/auth/login';
                } else {
                    $json['message'] = ajax_messages('error', lang('auth_reset_link_send_failed'));
                }
            }
            else {
                $json['validation'] = validation_messages();
            }
            echo json_encode($json);
        }
        else {
            $data['page_title'] = lang('form_reset_password');
            $this->pls_layout_lib->auth_layout('/auth/forgot_password', $data);
        }
    }

    /**
    * Admin and partner admin reset password
    */
    public function reset_password($code = NULL)
    {
        if($post = $this->input->post(NULL, TRUE)) {
            $fields = array('password', 'confirm_password');
            if ($this->pls_validation_lib->validate('user', $post['form'], $fields)) {
                if ($this->pls_auth_lib->reset_password($post['form']['verification_code'], $post['form']['password'])){
                    $this->pls_alert_lib->set_flash_messages('success', lang('auth_password_reset_success'));
                    $json['redirect'] = '/auth/login';
                }
                else {
                    $json['message'] = ajax_messages('error', lang('auth_password_reset_failed'));
                }
            }
            else {
                $json['validation'] = validation_messages();
            }
            echo json_encode($json);
        }
        else {
            if ($code && $this->pls_auth_lib->verify_user($code)){
                $data['form']['verification_code'] = $code;
                $data['page_title'] = lang('form_reset_password');
                $this->pls_layout_lib->auth_layout('/auth/reset_password', $data);
                return;
            }
            else {
                $this->pls_alert_lib->set_flash_messages('error', lang('auth_reset_link_verification_failed'));
                redirect('/auth/login');
            }
        }
    }

    /**
    * Admin and partner admin logout
    */
    function logout()
    {
        $this->pls_auth_lib->logout();
        redirect('/auth/login');
    }
}
