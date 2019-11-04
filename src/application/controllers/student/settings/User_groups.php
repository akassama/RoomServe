<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_groups extends Partner_Controller
{


	public function __construct()
    {
		// !!! load permission array before parent __construct
		$this->permissions = [
			'index'    => 'access_usergroups_partner',
			'get_list'    => 'access_usergroups_partner',
			'create'   => 'create_usergroups_partner',
			'update'   => 'update_usergroups_partner',
			'delete'   => 'delete_usergroups_partner',
		];
		parent::__construct();

		$this->module_name = 'groups_partner';
		$this->model = $this->usergroups_model;
    }

    /**
    * Rule groups list
    */
    public function index()
    {
        // page data
        $data['data'] = [
            'page_title'    => lang('module_user_groups'),
			'back_url'      => '/student/'.$this->partner->partner_id.'/settings',
            'add_btn'       => [
                'link'      => '/student/'.$this->partner->partner_id.'/settings/user_groups/create',
                'text'      => lang('module_btn_add_user_group')
            ],
            'access'		=> [
    			'add_btn'	=> 'create_usergroups_partner',
    		],
            'empty'         => [
                'text'      => '',
                'ico'       => 'administrators',
            ],
            'table'         => [
                'url'       => '/student/'.$this->partner->partner_id.'/settings/user_groups/get_list',
                'module'    => 'groups_partner',
                'type'      => 'all'
            ]
        ];

		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] = '/student/'.$this->partner->partner_id.'/settings/user_groups/get_list?preset='.$preset_name;
		}

        $this->pls_layout_lib->partner_layout('/templates/template-table-list', $data);
    }

    


    /**
    * Creates user group and redirects to update if success
    */
    public function create()
	{
		$data['group'] = ['type' => 'partner'];
		if ($id = $this->usergroups_model->save($data)) {

			//if user has not access to update
			$this->session->set_userdata(['new_item' => ['module' => 'user_groups', 'id' => $id]]);

			redirect("/student/".$this->partner->partner_id."/settings/user_groups/update/$id");

		}
		else {
			$this->pls_alert_lib->set_flash_messages('error', lang('group_create_failed'));
			redirect("/student/".$this->partner->partner_id."/settings/user_groups");
		}
    }


    /**
	* Updates user group and permissions
    */
	public function update($id = NULL)
	{
		if ($id && $data['data'] = $this->usergroups_model->load($id, 'partner')) {
			if ($post = $this->input->post(NULL, TRUE)) {
				$fields = array('name', 'status');
				if ($id == PARTNER_SUPER_ADMIN_GROUP) {
					$json['message'] = ajax_messages('warning', lang('group_update_denied'));
				}
				else{
					if ($data['group'] = $this->pls_validation_lib->validate('group', $post['form'], $fields)) {
						$data['permissions'] = $post['form']['permissions'];
						$data['group']['user_group_id'] = $data['data']->user_group_id;
						$newgroup = ($data['data']->status == STATUS_DRAFT);
						if ($this->usergroups_model->save($data)) {
							log_activity($id, NULL, $newgroup);
							$this->usergroups_model->save_partner_group_connection($this->partner->partner_id, $data['data']->user_group_id);
							//if user has not access to update
							if ($this->session->userdata('new_item_created')) {
								$this->session->unset_userdata('new_item');
								$this->pls_alert_lib->set_flash_messages('success', lang('group_create_success'));
								echo json_encode(['redirect' => '/student/'.$this->partner->partner_id.'/settings/user_groups']);
								return;
							}
							$json['message'] = ajax_messages('success', $newgroup?lang('group_create_success'):lang('group_update_success'));
						}
						else {
							$json['message'] = ajax_messages('error', $newgroup?lang('group_create_failed'):lang('group_update_failed'));
						}
					}
					else {
						$json['validation'] = validation_messages();
					}
				}
				echo json_encode($json);
			}
			else {
				$data['disabled'] = ($id == PARTNER_SUPER_ADMIN_GROUP)?'disabled':'';
				$data['show_usergroup_perms'] = ($id == PARTNER_SUPER_ADMIN_GROUP)?'':'user_group';
				$data['all_permissions'] = $this->usergroups_model->get_all_perms('partner');
				$data['permissions'] = $this->usergroups_model->get_group_perms($id);
				$this->pls_layout_lib->partner_layout('/student/settings/user_groups/form', $data);
			}
		}
		else {
			redirect("/student/".$this->partner->partner_id."/settings/user_groups");
		}
	}

	/**
	* Deletes user group
	*/
	public function delete($id = NULL)
	{
		if ($this->input->is_ajax_request() && $group = $this->usergroups_model->load($id, 'partner')) {
			if ($num = $this->usergroups_model->count_users_in_group($group->user_group_id)) {
				$json['message'] = ['status' => 'warning', 'text' => str_replace('{{num}}', $num, lang('group_delete_denied'))];
			}
			else {
				if ($id == PARTNER_SUPER_ADMIN_GROUP) {
					$json['message'] = ajax_messages('warning', lang('group_update_denied'));
				}
				else {
					$data['user_group_id'] = $group->user_group_id;
					$data = $this->pls_crud_lib->deleted('pls_users_groups', $data);
					if ($id = $this->usergroups_model->save($data)) {
						log_activity($id);
						$json['message'] = ajax_messages('success', lang('group_delete_success'));
					}
					else {
						$json['message'] = ajax_messages('error', lang('group_delete_failed'));
					}
				}

			}
			echo json_encode($json);
		}
		else {
			redirect("/student/".$this->partner->partner_id."/settings/user_groups");
		}
	}
}
