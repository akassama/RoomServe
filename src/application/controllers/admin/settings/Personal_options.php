<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_options extends Admin_Controller
{


    public function __construct()
    {
        // !!! load permission array before parent __construct
        parent::__construct();
        $this->load->model('admin/Personal_options_model', 'personal_options_model');

        $this->module_name = 'personal_options';
        $this->model = $this->personal_options_model;
    }

    /**
    * Rule cleaning_options list
    */
    public function index()
    {
        // page data
        $data['data'] = [
            'page_title'    => 'Personal options',
            'back_url'      => '/admin/settings',
            'add_btn'       => [
                'link'      => '/admin/settings/personal_options/create/',
                'text'      => 'Add a personal option'
            ],
            'access'        => [
                'add_btn'   => '',
            ],
            'empty'         => [
                'text'      => '',
                'ico'       => 'categories',
            ],
            'table'         => [
                'url'       => '/admin/settings/personal_options/get_list',
                'module'    => 'personal_options',
                'type'      => 'all'
            ]
        ];

        if ($preset_name = $this->input->get('preset')) {
            $data['data']['table']['url'] = '/admin/settings/personal_options/get_list?preset='.$preset_name;
        }

        $this->pls_layout_lib->admin_layout('/templates/template-table-list', $data);
    }


    /**
    * Creates cleaning_option and redirects to update if success
    */
    public function create()
    {
        if ($id = $this->personal_options_model->save([])) {
            //if user has not access to update
            $this->session->set_userdata(['new_item' => ['module' => 'personal_options', 'id' => $id]]);
            redirect("/admin/settings/personal_options/update/$id");
        }
        else {
            $this->pls_alert_lib->set_flash_messages('error', lang('personal_option_create_failed'));
            redirect("/admin/settings/personal_options");
        }
    }


    /**
    * Updates cleaning_option
    */
    public function update($id = NULL, $lang = NULL)
    {
        $data = [];

        if ($id && $data['data'] = $this->personal_options_model->load($id)) {
            //check is new data
            $new_data = ($data['data']->status == STATUS_DRAFT);
            if ($post = $this->input->post('form')) {
                $fields = ['status', 'name'];
                $personal_option_data = $this->pls_validation_lib->validate('personal_options', $post, $fields);

                if ($personal_option_data) {
                    $personal_option_data['personal_id'] = $data['data']->personal_id;

                    if ($this->personal_options_model->save($personal_option_data)) {
                        $json['message'] = ajax_messages('success', $new_data?lang('personal_options_create_success'):lang('personal_options_update_success'));
                    }
                    else {
                        $json['message'] = ajax_messages('error', $new_data?lang('personal_options_create_failed'):lang('personal_options_update_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
                echo json_encode($json);
            }
            else {
                $this->pls_layout_lib->admin_layout('/admin/settings/personal_options/form', $data);
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
        if ($this->input->is_ajax_request() && $personal_option = $this->personal_options_model->load($id)) {
            $data['personal_id'] = $personal_option->personal_id;
            $data = $this->pls_crud_lib->deleted('pls_personal_options', $data);
            if ($id = $this->personal_options_model->save($data)) {
                $json['message'] = ajax_messages('success', lang('personal_option_delete_success'));
            }
            else {
                $json['message'] = ajax_messages('error', lang('personal_option_delete_failed'));
            }
            echo json_encode($json);
        }
        else {
            show_404();
        }
    }
}
