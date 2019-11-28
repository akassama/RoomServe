<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_options extends Admin_Controller
{

	public function __construct()
    {
		// !!! load permission array before parent __construct

        parent::__construct();
        $this->load->model('admin/Payment_options_model', 'payment_options_model');

        $this->module_name = 'payment_options';
		$this->model = $this->payment_options_model;
    }

    /**
    * Rule cleaning_options list
    */
    public function index()
    {
        // page data
        $data['data'] = [
            'page_title'    => 'Payment options',
            'back_url'      => '/admin/settings/',
            'add_btn'       => [
                'link'      => '/admin/settings/payment_options/create/',
                'text'      => 'Add a payment option'
            ],
            'access'		=> [
    			'add_btn'	=> '',
    		],
            'empty'         => [
                'text'      => '',
                'ico'       => 'categories',
            ],
            'table'         => [
                'url'       => '/admin/settings/payment_options/get_list/',
                'module'    => 'payment_options',
                'type'      => 'all'
            ]
        ];

		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] = create_url('/orders/get_list?preset='.$preset_name);
		}

        $this->pls_layout_lib->admin_layout('/templates/template-table-list', $data);
    }


    /**
    * Creates cleaning_option and redirects to update if success
    */
    public function create()
	{
		if ($id = $this->payment_options_model->save([])) {
            //if user has not access to update
            
            $this->session->set_userdata(['new_item' => ['module' => 'payment_options', 'id' => $id]]);
			redirect("/admin/settings/payment_options/update/$id");
		}
		else {
			$this->pls_alert_lib->set_flash_messages('error', lang('payment_option_create_failed'));
			redirect("/admin/settings/payment_options");
		}
    }


    /**
	* Updates cleaning_option
    */
	public function update($id = NULL, $lang = NULL)
	{
        $data = [];

	    if ($id && $data['data'] = $this->payment_options_model->load($id)) {
            //check is new data
            $new_data = ($data['data']->status == STATUS_DRAFT);
			if ($post = $this->input->post('form')) {
				$fields = ['status', 'name'];
                $payment_option_data = $this->pls_validation_lib->validate('payment_options', $post, $fields);

                if ($payment_option_data) {
                    $payment_option_data['payment_id'] = $data['data']->payment_id;

                    if ($this->payment_options_model->save($payment_option_data)) {
                        $json['message'] = ajax_messages('success', $new_data?lang('payment_options_create_success'):lang('payment_options_update_success'));
                    }
                    else {
                        $json['message'] = ajax_messages('error', $new_data?lang('payment_options_create_failed'):lang('payment_options_update_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
                echo json_encode($json);
			}
			else {
				$this->pls_layout_lib->admin_layout('/admin/settings/payment_options/form', $data);
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
		if ($this->input->is_ajax_request() && $payment_option = $this->payment_options_model->load($id)) {
            $data['payment_id'] = $payment_option->payment_id;
			$data = $this->pls_crud_lib->deleted('pls_payment_options', $data);
            if ($id = $this->payment_options_model->save($data)) {
                $json['message'] = ajax_messages('success', lang('payment_option_delete_success'));
            }
            else {
                $json['message'] = ajax_messages('error', lang('payment_option_delete_failed'));
            }
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}
}
