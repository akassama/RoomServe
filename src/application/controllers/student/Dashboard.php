<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Partner_Controller
{

    public $all_loyalty_schemes;

    public function __construct()
    {
        parent::__construct();

    }

    public function index($id = NULL)
    {
        $data = [];
        $this->pls_layout_lib->partner_layout('/student/dashboard', $data);
    }
    public function settings()
	{
		$data = [];
        $this->pls_layout_lib->partner_layout('/student/settings/settings', $data);
	}


	public function reports()
	{
		$data = [];
		$this->pls_layout_lib->partner_layout('/student/reports/reports', $data);
	}


    public function profile()
    {
        if ($this->user->user_role_id == USER_ROLE_ADMINISTRATOR)   redirect('/admin/profile');
        $data['data'] = $this->users_model->load($this->user->user_id, USER_ROLE_PARTNER_ADMINISTRATOR);
        if($post = $this->input->post('form')) {
            $fields = array('first_name');
            if ($pass_changed = isset($post['password']))
                    array_merge($fields, ['password', 'confirm_password']);
            //if user's email is new or changed
            if ($data['data']->email != $post['email'])
                $fields[] = 'email';
            if ($userdata = $this->pls_validation_lib->validate('user', $post, $fields, ['email' => ['is_unique']])) {
                $userdata['user_id'] = $data['data']->user_id;
                if($pass_changed){
                    unset($userdata['confirm_password']);
                    $userdata['password'] = $this->pls_auth_lib->hash_password($userdata['password'], $data['data']->user_id);
                }
                if ($this->users_model->save($userdata)) {
                    log_activity($this->user->user_id);
                    //update session userdata
                    $this->pls_auth_lib->update_session_userdata();
                    $this->pls_alert_lib->set_flash_messages('success', lang('admin_profile_update_success'));
                    $json['redirect'] = '/student/'.$this->student->user_id.'/profile';
                }
                else {
                    $json['message'] = ajax_messages('error', lang('admin_profile_update_failed'));
                }
            }
            else {
                $json['validation'] = validation_messages();
            }
            echo json_encode($json);
        }
        else{
            $this->pls_layout_lib->partner_layout('/student/administrators/my_profile', $data);
        }
    }
}
