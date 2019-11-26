<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller
{


	public function __construct()
    {
		
        parent::__construct();
        $this->load->model('Users_model', 'users_model');
		$this->module_name = 'administrators';
		$this->model = $this->users_model;
    }

    /**
    * Users list
    */
    public function index()
    {
    	// page data
    	$data['data'] = [
    		'page_title' 	=> 'Users',
    		'back_url'		=> '/admin/dashboard',
    		'add_btn' 		=> [
    			'link' 		=> '/admin/users/create',
    			'text' 		=> "Add user"
    		],
    		'access'		=> [
    			'add_btn'	=> 'create_administrators',
    		],
    		'empty'         => [
                'text'      => '',
                'ico'       => 'administrators',
            ],
    		'table'			=> [
    			'url'		=> '/admin/users/get_list',
    			'module'	=> 'administrators',
    			'type'		=> 'all'
    		]
    	];

		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] .= '?preset='.$preset_name;
		}

        $this->pls_layout_lib->admin_layout('/templates/template-table-list', $data);
    }


	/**
	* Creates user id with status draft and redirects to update if success
	*/
	public function create()
	{
		$data = ['user_role_id' => USER_ROLE_PARTNER_ADMINISTRATOR];
		if ($id = $this->users_model->save($data)) {

			//if user has not access to update
			$this->session->set_userdata(['new_item' => ['module' => 'administrators', 'id' => $id]]);

			redirect("/admin/users/update/$id");
		}
		else {
			$this->pls_alert_lib->set_flash_messages('error', lang('admin_create_failed'));
			redirect("/admin/administrators");
		}
	}


	/**
	* Updates admin user
	*/
	public function update($id = NULL)
	{
		if ($id && $data['data'] = $this->users_model->load($id)) {
			if ($id == $this->user->user_id) 	redirect('/admin/profile');
			if ($id == SUPER_ADMINISTRATOR) {
				$this->pls_alert_lib->set_flash_messages('warning', lang('admin_create_denied'));
				redirect("/admin/administrators");
			}
			if($post = $this->input->post('form')) {
				$fields = array('first_name', 'status');
				//check if new user created or not
				$newuser = $data['data']->status == STATUS_DRAFT;
				if ($pass_changed = isset($post['password']))
					array_merge($fields, ['password', 'confirm_password']);
				//if user's email is new or changed
				if ($data['data']->email != $post['email'])
					$fields[] = 'email';
				if ($userdata = $this->pls_validation_lib->validate('user', $post, $fields, ['email' => ['is_unique']])) {
					$userdata['user_id'] = $data['data']->user_id;
					$userdata['user_role_id'] = $post['user_role_id'];
					if($pass_changed){
						unset($userdata['confirm_password']);
						$userdata['password'] = $this->pls_auth_lib->hash_password($userdata['password'], $id);
					}
					if ($this->users_model->save($userdata)) {
						//if user has not access to update
						if ($this->session->userdata('new_item_created')) {
							$this->session->unset_userdata('new_item');
							$this->pls_alert_lib->set_flash_messages('success', lang('admin_create_success'));
                            redirect("/admin/administrators");
                            return;
						}
						$json['message'] = ajax_messages('success', $newuser?lang('admin_create_success'):lang('admin_update_success'));
					}
					else {
						$json['message'] = ajax_messages('error', $newuser?lang('admin_create_failed'):lang('admin_update_failed'));
					}
				}
				else {
					$json['validation'] = validation_messages();
				}
				$this->pls_auth_lib->update_session_userdata();
				echo json_encode($json);
			}
			else {
				$data['user_group_id'] = $this->usergroups_model->get_user_group_id($data['data']->user_id);
				$this->pls_layout_lib->admin_layout('/admin/administrators/form', $data);
			}
		}
		else {
			show_404();
		}
	}


	/**
	* Deletes user
	*/
	public function delete($id = NULL)
	{
		if ($this->input->is_ajax_request() && $user = $this->users_model->load($id)) {
			if ($id == $this->user->user_id || $id == SUPER_ADMINISTRATOR) {
				$json['message'] = ajax_messages('warning', lang('admin_delete_denied'));
			}
			else {
				$data['user_id'] = $user->user_id;
				$data = $this->pls_crud_lib->deleted('pls_users', $data);
				if ($id = $this->users_model->save($data)) {
					log_activity($id);
					$json['message'] = ajax_messages('success', lang('admin_delete_success'));
				}
				else {
					$json['message'] = ajax_messages('error', lang('admin_delete_failed'));
				}
			}
			if ($this->input->get('redirect')) {
			  $json['redirect'] = create_url('/users');
			}
			echo json_encode($json);
		}
		else {
			redirect(create_url('/users'));
		}
	}


	/*
   *  Get admins list for partner responsible person
   */
  	public function get_ajax_admins()
    {
        if ($this->input->is_ajax_request()) {
		$options['where']['pls_users.status'] = USER_STATUS_ACTIVE;
		    $options['fields'] = 'pls_users.user_id as key, CONCAT(pls_users.first_name," ", COALESCE(pls_users.last_name, "")) as val';
		    $options['order_by'] = ['key' => 'val', 'direction' => 'ASC'];
		    echo json_encode($this->admins_model->admins_list($options)); 
		}
    }
}
