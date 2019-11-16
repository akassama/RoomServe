<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller
{

	public function __construct()
    {
		
        parent::__construct();
        $this->load->library('email');

        //Load Orders model
        $this->load->model('admin/Orders_model', 'orders_model');
        $this->load->model('Users_model', 'users_model');
        $this->load->model('admin/Cleaning_options_model', 'cleaning_options_model');
        $this->load->model('Messages_model', 'messages_model');
		$this->load->model('Common_Orders_model', 'common_orders_model');

		$preset_name = $this->input->get('preset');
		//choose module name for grid according to preset name
		$this->module_name = in_array($preset_name, ['pending','declined'])?'orders_approval':'orders';
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
            'back_url'      => '/admin/dashboard',
            'add_btn'       => [
                'link'      => create_url("/orders/create"),
                'text'      => lang('module_btn_add_order')
            ],
            'access'        => [
                'add_btn'   => 'create_orders',
            ],
            'empty'         => [
                'text'      => '',
                'ico'       => 'reports',
            ],
            'table'         => [
                'url'       => create_url('/orders/get_list'),
                'module'    => 'orders',
                'type'      => 'all'
            ]
        ];
		if ($preset_name = $this->input->get('preset')) {
			$data['data']['table']['url'] = create_url('/orders/get_list?preset='.$preset_name);
		}

        $this->pls_layout_lib->admin_layout('/templates/template-table-list', $data);

    }


    /**
     * Creates order id with status = -2 and redirects to update if success
     */
    public function create() {
        if ($id = $this->orders_model->save([])){
            redirect(create_url("/orders/update/$id"));
        }
        else {
            $this->pls_alert_lib->set_flash_messages('error', lang('order_create_failed'));
            redirect(create_url("/orders"));
        }
    }


    /**
     * Updates order
     * Edit Order Use Case
     */

    public function update($id = NULL, $lang = NULL) {
        //checking if order sended to approve
        if($this->orders_model->pending_approval($id)){
			$url = '/orders/approve/'.$id;
			
            redirect(create_url($url));
        }
        $data = $this->handle_multilanguage($id, $lang);
        if ($id && $data['data'] = $this->orders_model->load($id, $data['lang'])) {
            //check is new data
            $new_data = ($data['data']->status == STATUS_DRAFT);
            if ($post = $this->input->post('form')) {
				if ($data['data']->status == ORDER_STATUS_CANCELLED) {
					return;
				}
                $fields = ['name', 'description', 'payment_type', 'order_date'];
                if ($order_data = $this->pls_validation_lib->validate('orders', $post, $fields)) {
                    $order_data['order_id'] = $data['data']->order_id;
					$order_data['status'] = 1;
					$order_trans_data['name'] = $order_data['name'];  unset($order_data['name']);
					$order_trans_data['description'] = $order_data['description'];  unset($order_data['description']);
					$order_trans_data['order_id'] = $data['data']->order_id;
                    $order_trans_data['lang'] = $data['lang'];
					if ($this->orders_model->save($order_data) && $this->orders_model->save_translation($order_trans_data)) {
						log_activity($id, NULL, $new_data);
						$this->handle_other_order_operations($id, $post, $order_data, $new_data);
                        $json['message'] = ajax_messages('success', $new_data?lang('order_create_success'):lang('order_update_success'));
                        $this->send_email($data['data'], lang('email_theme_update'), lang('email_message_update'));
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
                $this->pls_layout_lib->admin_layout('/admin/orders/form', $data);
            }
        }
        else {
            show_404();
        }
    }


    /**
     * Delete order
     * Delete Order Use Case
     */
    public function delete($order_id)
    {
		if ($this->input->is_ajax_request() ) {
	        $json['success'] = FALSE;
	        if ($order = $this->orders_model->load($order_id)) {
	            $data['order_id'] = $order->order_id;
	            $data = $this->pls_crud_lib->deleted('pls_orders', $data);

	            if ($this->orders_model->save($data)) {
					log_activity($order_id);
	                $json['message'] = ajax_messages('success', lang('order_delete_success'));
	                $json['success'] = TRUE;
                    $json['redirect'] = create_url("/orders");
                    $this->send_email($order, lang('email_theme_delete'), lang('email_message_delete'));

                } else {
	                $json['message'] = ajax_messages('error', lang('order_delete_failed'));
	            }
	        }
            if ($this->input->get('redirect')) {
                $json['redirect'] = create_url('/orders');
            }
            echo json_encode($json);
        }
        else {
            redirect(create_url('/orders'));
        }
    }



    /**
     * Approve order
     * Accept Order Use Case
     */
    public function approve($id = NULL, $lang = NULL)
	{
        //checking if order sended to approve
        if(!$this->orders_model->pending_approval($id)) {
            redirect('/admin/orders/update/'.$id);
        }
		$data = $this->handle_multilanguage($id, $lang);
        if ($id && $data['draft_data'] = $this->orders_model->load($id, $data['lang'])) {
            if ($post = $this->input->post('form')) {
				$fields = ['name', 'description'];
                if ($order_data = $this->pls_validation_lib->validate('orders', $post, $fields)) {
					$order_data = $this->pls_crud_lib->approved('pls_orders', $order_data);
                    $order_data['order_id'] = $data['draft_data']->order_id;
                    $order_data['status'] = ORDER_STATUS_APPROVED;
                    $order_data['reason_id'] = 0;
					$order_trans_data['name'] = $order_data['name'];  unset($order_data['name']);
					$order_trans_data['description'] = $order_data['description'];  unset($order_data['description']);
                    $order_trans_data['order_id'] = $data['draft_data']->order_id;
                    $order_trans_data['lang'] = $data['lang'];
					//if order status changed checking childs and parent
					$order_data = $this->pls_crud_lib->status_changed('pls_orders', $order_data, $data['draft_data']->status);
                    if ($this->orders_model->save($order_data) && $this->orders_model->save_translation($order_trans_data)) {
						log_activity($id);
						$this->handle_other_order_operations($id, $post, $order_data, FALSE);
					    $json['message'] = ajax_messages('success', lang('order_update_success'));
                        $json['redirect'] = create_url("/orders");
                        $this->send_email($data['draft_data'], lang('email_theme_approve'), lang('email_message_approve'));
                    }
                    else {
                        $json['message'] = ajax_messages('error', lang('order_update_failed'));
                    }
                }
                else {
                    $json['validation'] = validation_messages();
                }
                echo json_encode($json);
            }
			else {
				$data = $this->prepare_order_data($id, $data, TRUE);
                $this->pls_layout_lib->admin_layout('/admin/orders/approve', $data);
            }
        }
        else {
            show_404();
        }
    }


    /**
     * Ajax decline order
     * Decline Order Use Case
     */
    public function decline(){
        if($this->input->is_ajax_request()){
            $form = $this->input->post('form');
            $json['status'] = FALSE;
            if($form) {
                $order_data['order_id'] = $form['id'];
                $order_data['status'] = ORDER_STATUS_DECLINED;
                $order_data['reason_id'] = 0;
				$order_data = $this->pls_crud_lib->status_changed('pls_orders', $order_data);
                if($this->orders_model->save($order_data)) {
					log_activity($form['id']);
                    $this->messages_model->save_message($form['id'], TYPE_VENUE, $form['message'], 'decline');
                    $json['status'] = TRUE;
                    $this->send_email($this->orders_model->load($form['id']), lang('email_theme_decline'), lang('email_message_decline') . lang('email_message_reason') . $form['message']);
                    $json['redirect'] = create_url("/orders");
                }

            }
            echo json_encode($json);
        }
    }


	/**
	 * deactivate order
     * Deactivate Order Use Case
     */
	public function deactivate($order_id)
	{
		if ($this->input->is_ajax_request() ) {
			$order = $this->orders_model->load($order_id, $this->lang->default_lang);
			$order_data['order_id'] = $order_id;
			//$order_data['student_id'] = $order->student_id;
			$action = 'deactivate';
			if ($order->status == ORDER_STATUS_INACTIVE) {
				$order_data['status'] = ORDER_STATUS_APPROVED;
				$action = 'activate';
			}
			else {
				$order_data['status'] = ORDER_STATUS_INACTIVE;
			}
			$order_data = $this->pls_crud_lib->status_changed('pls_orders', $order_data);
			if($this->orders_model->save($order_data)) {
				log_activity($order_id, $action);
				if ($order->status == $order_data['status']) {
					//$partner = $this->partners_model->load($order->student_id);
					$json['message'] = ajax_messages('warning', str_replace(['{{Order_name}}'], [$order->name], lang('order_deactivate_denied')), FALSE);



                }
				else {
					$json['message'] = ajax_messages('success', lang('order_deactivate_success'), FALSE);
                    $this->send_email($order, lang('email_theme_deactivate'), lang('email_message_deactivate'));
				}
			}
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}


	/**
	* Cancel order
     * Cancel Order Use Case
	*/
	public function cancel($order_id)
	{
		if ($this->input->is_ajax_request() ) {
			$json['success'] = FALSE;
			$form = $this->input->post('form');
			$order = $this->orders_model->load($order_id);
			$order_data['order_id'] = $order_id;
			$order_data['order_id'] = $order->order_id;
			$order_data['status'] = ORDER_STATUS_CANCELLED;
			$order_data = $this->pls_crud_lib->status_changed('pls_orders', $order_data);
			if($this->orders_model->save($order_data)) {
				log_activity($order_id);
				if ($form['message']) {
					$this->messages_model->save_message($form['id'], 'order', $form['message'], 'cancel');
				}
                $this->send_email($order, lang('email_theme_cancel'), lang('email_message_cancel') . lang('email_message_reason') . $form['message']);
                $json['message'] = '';
				$json['success'] = TRUE;
                $json['redirect'] = create_url("/orders");
			}
			echo json_encode($json);
		}
		else {
			show_404();
		}
	}

    /**
     * Cancel order
     * Send Notification Use Case
     */
	public function send_email($order, $theme, $message){
	    $student_id = $order->student_id;
        $user = $this->users_model->load($student_id);
        $user_email = $user->email;

        $this->email->from(getenv('EMAIL_USER'));
        $this->email->to($user_email);

        $this->email->subject($theme);
        $this->email->message($message);
        $this->email->send();
    }


    /*
    *    - Методы этого блока получают данные в виде key => value из метода ---_list основной модели контроллера (те, что мы можем видеть в таблице).
    *      Используется для select'а в редактировании и фильтрах.
    */
    public function get_ajax_orders($partner_id = NULL)
    {
        if ($this->input->is_ajax_request()) {
            if($partner_id) $options['where']['pls_orders.partner_id'] = $partner_id;
            $options['fields'] = 'pls_orders.order_id as key, pls_orders_translations.name as val';
			if ($this->input->get('draft') !== NULL) {
				$options['where']['pls_orders.draft_order_id'] = 0;
			}
            $options['group_by'] = 'pls_orders.order_id';
            $options['order_by'] = ['key' => 'pls_orders_translations.name', 'direction' => 'ASC'];
            echo json_encode($this->orders_model->get_grid_list($options));
        }
    }
    //-------------------------------------------------------------------------
    public function get_ajax_partners()
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->partners_model->get_ajax_partners());
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



    //-------------------------------------------------------------------------
    public function get_ajax_creators()
    {
        if ($this->input->is_ajax_request()) {
            $options['fields'] = 'pls_orders.created_by as key, CONCAT(pls_users.first_name," ", COALESCE(pls_users.last_name, "")) as val';
            $options['group_by'] = 'pls_users.user_id';
            $options['order_by'] = ['key' => 'val', 'direction' => 'ASC'];
            echo json_encode($this->orders_model->get_grid_list($options));
        }
    }
    //-------------------------------------------------------------------------
    public function get_ajax_approvers()
    {
        if ($this->input->is_ajax_request()) {
            $options['where']['pls_orders.approved_by !='] = 0;
            $options['fields'] = 'pls_orders_approved_by_users.user_id as key, IFNULL(CONCAT(pls_orders_approved_by_users.first_name," ", COALESCE(pls_orders_approved_by_users.last_name, "")),"") as val';
            $options['group_by'] = 'pls_orders_approved_by_users.user_id';
            $options['order_by'] = ['key' => 'val', 'direction' => 'ASC'];
            echo json_encode($this->orders_model->get_grid_list($options));
        }
    }

    /* --------------------------------------------------------------------- */

	/*
	 *  Prepare order data to render
	 */
	private function prepare_order_data($id, $data, $for_approve = FALSE)
	{
		if ($for_approve) {
			//load original data
			$data['original_data'] = $this->orders_model->load_original($id, $data['lang']);
			if(isset($data['original_data'])) {
				$data['original_data'] = $this->set_order_attributes($data['original_data']);
			}
			//load draft data
			$data['draft_data'] = $this->set_order_attributes($data['draft_data']);
		}
		else {
			$data['data'] = $this->set_order_attributes($data['data']);
		}
		//common
		$data['categories'] = $this->cleaning_options_model->get_all_categories('order');
		$data['personnels'] = [
            ['personnel_id' => 1, 'name' => 'Olga'],
            ['personnel_id' => 2, 'name' => 'Natasha'],
        ];
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
		$this->orders_model->create_order_copy($id);
	}



}
