<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Partner_Controller
{
	public function __construct()
    {
		
        parent::__construct();
		//Load Orders model
        $this->load->model('student/Orders_model', 'orders_model');
        $this->load->model('admin/Cleaning_options_model', 'cleaning_options_model');
        $this->load->model('Messages_model', 'messages_model');
		$this->load->model('Common_Orders_model', 'common_orders_model');
		
		$preset_name = $this->input->get('preset');
		//choose module name for grid according to preset name
		$this->module_name = in_array($preset_name, ['pending','declined'])?'orders_approval_partner':'order_student';
		$this->model = $this->orders_model;
    }

    /**
    * Rule orders list
    */
    public function index()
    {
        // page data
        $data['data'] = [
            'page_title'    => lang('module_orders'),
            'back_url'      => create_partner_url("/dashboard"),
            'add_btn'       => [
                'link'      => create_partner_url("/orders/create"),
                'text'      => lang('module_btn_add_order')
            ],
            'access'        => [
                'add_btn'   => '',
            ],
            'empty'         => [
                'text'      => '',
                'ico'       => 'reports',
            ],
            'table'         => [
                'url'       => create_partner_url('/orders/get_list'),
                'module'    => 'order_student',
                'type'      => 'all'
            ]
        ];
		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] = create_partner_url('/orders/get_list?preset='.$preset_name);
			
		}
        $this->pls_layout_lib->partner_layout('/templates/template-table-list', $data);
    }


    /**
    * Creates order id with status = -2 and redirects to update if success
    */
    public function create() {
        if ($id = $this->orders_model->save(['student_id' => $this->student->user_id])) {
            redirect(create_partner_url("/orders/update/$id"));
        }
        else {
            $this->pls_alert_lib->set_flash_messages('error', lang('order_create_failed'));
            redirect(create_partner_url("/orders"));
        }
    }


    /**
    * Updates order
    */
    public function update($id = NULL, $lang = NULL)
	{
		$data = $this->handle_multilanguage($id, $lang);
        if ($id && $data['data'] = $this->orders_model->load($id, $data['lang'])) {
			if ($data['data']->student_id != $this->student->user_id) {
				show_403();
			}
            //check is new data
            $new_data = ($data['data']->status == STATUS_DRAFT);
            if ($post = $this->input->post('form')) {
				$fields = ['name', 'description', 'paymnet_type', 'order_date'];
                if ($order_data = $this->pls_validation_lib->validate('orders', $post, $fields)) {
                    $order_data['order_id'] = $data['data']->order_id;
                    $order_data['reason_id'] = $new_data ? STATUS_REASON_VENUE_AWAITING_APPROVAL:STATUS_REASON_VENUE_AWAITING_CHANGES;
                    $order_data['status'] = ORDER_STATUS_PENDING;
					$order_trans_data['name'] = $order_data['name'];  unset($order_data['name']);
					$order_trans_data['description'] = $order_data['description'];  unset($order_data['description']);
                    $order_trans_data['order_id'] = $data['data']->order_id;
                    $order_trans_data['lang'] = $data['lang'];
                    if ($this->orders_model->save($order_data) && $this->orders_model->save_translation($order_trans_data)) {
						log_activity($id, NULL, $new_data);
						$this->handle_other_order_operations($id, $post, $order_data, $new_data);
						$json['message'] = ajax_messages('success', $new_data?lang('order_create_success'):lang('order_update_success'));
                    }
                    else {
                        $json['message'] = ajax_messages('error', $new_data?lang('order_create_failed'):lang('order_update_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
                echo json_encode($json);
            }
            else {
				$data = $this->prepare_order_data($id, $data);
                $this->pls_layout_lib->partner_layout('/student/orders/form', $data);
            }
        }
        else {
            show_404();
        }
    }


	/**
	 * Delete order
	 */
	public function delete($order_id)
	{
		if ($this->input->is_ajax_request() ) {
			$json['success'] = FALSE;
			if ($order = $this->orders_model->load($order_id)) {
				if ($order->partner_id != $this->partner->partner_id) {
					show_403();
				}
				$original_order = $this->orders_model->load_original($order_id, $this->lang->default_lang, FALSE);
				if (in_array($original_order->status, [ORDER_STATUS_PENDING, ORDER_STATUS_DECLINED, STATUS_DRAFT])) {
					$data['order_id'] = $order->order_id;
					$data = $this->pls_crud_lib->deleted('pls_orders', $data);
					if ($this->orders_model->save($data)) {
						log_activity($order_id);
						$json['message'] = ajax_messages('success', lang('order_delete_success'));
						$json['redirect'] = '/admin/orders';
						$json['success'] = TRUE;
					} else {
						$json['message'] = ajax_messages('error', lang('order_delete_failed'));
					}
				}
			}
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}


	/**
	 * Cancel changes in draft order
	 */
	public function reset($order_id)
	{
		if ($this->input->is_ajax_request() ) {
			$json['success'] = FALSE;
			if ($this->orders_model->load($order_id)) {
				if ($this->orders_model->reset_draft_order($order_id)) {
					log_activity($order_id);
					//delete decline  messages
					$this->messages_model->delete_message($order_id, TYPE_VENUE, 'decline');
					$json['message'] = ajax_messages('success', lang('order_change_reset_success'));
					$json['success'] = TRUE;
				} else {
					$json['message'] = ajax_messages('error', lang('order_change_reset_failed'));
				}
			}
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}

    /*
    *    - Методы этого блока получают данные в виде key => value из метода ---_list основной модели контроллера (те, что мы можем видеть в таблице).
    *      Используется для select'а в редактировании и фильтрах.
    */
    public function get_ajax_orders()
    {
        if ($this->input->is_ajax_request()) {
            $options['fields'] = 'pls_orders.order_id as key, pls_orders_translations.name as val';
            $options['group_by'] = 'pls_orders.order_id';
            $options['order_by'] = ['key' => 'pls_orders_translations.name', 'direction' => 'ASC'];
            echo json_encode($this->orders_model->orders_list($options));
        }
    }
	//-------------------------------------------------------------------------
	public function get_ajax_partner_orders()
	{
		if ($this->input->is_ajax_request()) {
			$options['where']['pls_orders.draft_order_id'] = 0;
			$options['fields'] = 'pls_orders.order_id as key, pls_orders_translations.name as val';
			$options['group_by'] = 'pls_orders.order_id';
			$options['order_by'] = ['key' => 'pls_orders_translations.name', 'direction' => 'ASC'];
			echo json_encode($this->orders_model->orders_list($options));
		}
	}

    //-------------------------------------------------------------------------
    public function get_ajax_categories()
    {
        if ($this->input->is_ajax_request()) {
            $options['fields'] = 'pls_cleaning_options.name as val, pls_cleaning_options.option_id as key';
            $options['group_by'] = 'pls_cleaning_options.option_id';
            $options['order_by'] = ['key' => 'pls_cleaning_options.name', 'direction' => 'ASC'];
            echo json_encode($this->orders_model->get_grid_list($options));
        }
    }
    /* --------------------------------------------------------------------- */
	public function check_order_availability()
    {
        if ($this->input->is_ajax_request()) {
			$result = 0;
			if ($this->orders_model->orders_count([])) {
				$result = 1;
            };
            echo $result;
        }
    }

	/*
	 *  Prepare order data to render
	 */
	private function prepare_order_data($id, $data)
	{
		//load original data
		$data['original_data'] = $this->orders_model->load_original($id, $data['lang']);
		if(isset($data['original_data'])) {
			$data['original_data'] = $this->set_order_attributes($data['original_data']);
		}
		//load draft data
		$data['data'] = $this->set_order_attributes($data['data']);
		//common
		$data['categories'] = $this->cleaning_options_model->get_all_categories('order');
		$data['limit'] = project('location_limit');
		$data['languages'] = $this->config->item('site_languages');
		$data['decline_message'] = $this->messages_model->get_message($id, TYPE_VENUE, 'decline');
		$data['cancel_message'] = $this->messages_model->get_message($id, TYPE_VENUE, 'cancel');

		return $data;
	}


	private function set_order_attributes($order)
	{

		return $order;
	}


	/*
	 *  Handle multilanguage
	 */
	private function handle_multilanguage($id, $lang)
	{
		//if empty default lang data show error
		$data['lang'] = ($lang ? $lang : $this->lang->get_current_lang());
		$data['is_access_multilang'] = $this->orders_model->load_translation($id, $this->lang->default_lang);
		if($data['lang'] != $this->lang->default_lang && !$data['is_access_multilang']){
			show_403();
		}
		return $data;
	}


	/*
	 *  Handle other order operations
	 */
	private function handle_other_order_operations($id, $post, $order_data, $new_data)
	{
		//delete decline  messages
		$this->messages_model->delete_message($id, TYPE_VENUE, 'decline');


		//after save, copy order to original
		$original_order_id = $this->orders_model->create_order_copy($id);
	}


	/*
	 *  New offer operations
	*/
	private function handle_new_offers($post, $order_id)
	{
		//change order offers status if order is newly created
		if (isset($post['offer'])) {
			foreach ($post['offer'] as $key => $value) {
				$offer['offer_id'] = $key;
				$offer['status'] = OFFER_STATUS_PENDING;
				$offer['order_id'] = $order_id;
				$this->offers_model->save($offer);
			}
		}
	}


	/*
	 *  New location operations
	*/
	private function handle_new_locations($post, $order_id)
	{
		//change order locations status if order is newly created
		if (isset($post['location'])) {
			foreach ($post['location'] as $key => $value) {
				$location['location_id'] = $key;
				$location['status'] = STATUS_ACTIVE;
				$location['type_id'] = $order_id;
				$location['type'] = TYPE_VENUE;
				$this->locations_model->save($location);
			}
		}
	}
}
