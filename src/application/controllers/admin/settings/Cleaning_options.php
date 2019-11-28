<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cleaning_options extends Admin_Controller
{


	public function __construct()
    {
		// !!! load permission array before parent __construct

        parent::__construct();
        $this->load->model('admin/Cleaning_options_model', 'cleaning_options_model');

        $this->module_name = 'cleaning_options';
		$this->model = $this->cleaning_options_model;
    }

    /**
    * Rule cleaning_options list
    */
    public function index()
    {
        // page data
        $data['data'] = [
            'page_title'    => 'Cleaning options',
            'back_url'      => '/admin/settings',
            'add_btn'       => [
                'link'      => '/admin/settings/cleaning_options/create',
                'text'      => 'Add a cleaning option'
            ],
            'access'		=> [
    			'add_btn'	=> '',
    		],
            'empty'         => [
                'text'      => '',
                'ico'       => 'categories',
            ],
            'table'         => [
                'url'       => '/admin/settings/cleaning_options/get_list',
                'module'    => 'cleaning_options',
                'type'      => 'all'
            ]
        ];

		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] = '/admin/settings/cleaning_options/get_list?preset='.$preset_name;
		}

        $this->pls_layout_lib->admin_layout('/templates/template-table-list', $data);
    }


    /**
    * Creates cleaning_option and redirects to update if success
    */
    public function create()
	{
		if ($id = $this->cleaning_options_model->save([])) {
            //if user has not access to update
            $this->session->set_userdata(['new_item' => ['module' => 'cleaning_options', 'id' => $id]]);
			redirect("/admin/settings/cleaning_options/update/$id");
		}
		else {
			$this->pls_alert_lib->set_flash_messages('error', lang('cleaning_option_create_failed'));
			redirect("/admin/settings/cleaning_options");
		}
    }


    /**
	* Updates cleaning_option
    */
	public function update($id = NULL, $lang = NULL)
	{
        $data = [];

	    if ($id && $data['data'] = $this->cleaning_options_model->load($id)) {
            //check is new data
            $new_data = ($data['data']->status == STATUS_DRAFT);
			if ($post = $this->input->post('form')) {
				$fields = ['status', 'name'];
                $cleaning_option_data = $this->pls_validation_lib->validate('cleaning_options', $post, $fields);

                if ($cleaning_option_data) {
                    $cleaning_option_data['option_id'] = $data['data']->option_id;

                    if ($this->cleaning_options_model->save($cleaning_option_data)) {
                        $json['message'] = ajax_messages('success', $new_data?lang('cleaning_option_create_success'):lang('cleaning_option_update_success'));
                    }
                    else {
                        $json['message'] = ajax_messages('error', $new_data?lang('cleaning_option_create_failed'):lang('cleaning_option_update_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
                echo json_encode($json);
			}
			else {
				$this->pls_layout_lib->admin_layout('/admin/settings/cleaning_options/form', $data);
			}
		}
		else {
			show_404();
		}
	}

	/**
	* Delete cleaning_option
	*/
	public function delete($id = NULL)
	{
		if ($this->input->is_ajax_request()) {
		    $cleaning_option = $this->cleaning_options_model->load($id);
            $data['option_id'] = $cleaning_option->option_id;
			$data = $this->pls_crud_lib->deleted('pls_cleaning_options', $data);
            if ($id = $this->cleaning_options_model->save($data)) {
                $json['message'] = ajax_messages('success', lang('cleaning_option_delete_success'));
            }
            else {
                $json['message'] = ajax_messages('error', lang('cleaning_option_delete_failed'));
            }
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}
}
