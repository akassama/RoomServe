<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model CRUD manipulation Library
 *
 * @author     bzimor <bobzimor@gmail.com>
 * @version    2.0
 */
class Pls_crud_lib
{
    public $CI;

    public $user_id;

    public $message;

    public $message_type = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();

        if ($this->CI->session->userdata('user')) {
            $this->user_id = $this->CI->session->userdata('user')->user_id;
        }
    }

    /**
     * Set additional datas on create
     */
    public function created($table, $data = [], $add_status = TRUE)
    {
        if ($add_status && !isset($data['status'])) {
            $data[$table.'.status'] = STATUS_DRAFT;
        }
        return $data;
    }

    /**
     * Set additional datas on update
     */
    public function updated($table, $data = [])
    {
        $data[$table.'.updated_at'] = date('c');
        return $data;
    }


    /**
     * Set additional datas on approval
     */
    public function approved($table, $data = [])
    {
        $data[$table.'.approved_at'] = date('c');
        $data[$table.'.reason_id'] = 0;
        return $data;
    }


    /**
     * Set additional datas on delete
     */
    public function deleted($table, $data = [])
    {
        $data['is_deleted'] = 1;
        $data['deleted_by'] = $this->user_id;
        $data['deleted_at'] = date('Y-m-d H:i:s');
        if ($table == 'pls_partners') {
            $this->partner_delete_triggers($data);
        }
        elseif ($table == 'pls_orders') {
            $this->order_delete_triggers($data);
        }
        elseif ($table == 'pls_offers') {
            $this->offer_delete_triggers($data);
        }
        elseif ($table == 'pls_post_locations') {
            $this->location_delete_triggers($data);
        }

        return $data;
    }


    /**
     * Set additional datas when item is deactivated
     */
    public function status_changed($table, $data = [], $old_status = NULL, $partner_id = NULL)
    {
        if (isset($data['status'])) {
            switch ($table) {
                case 'pls_partners':
                    $data = $this->partner_status_change_triggers($data, $old_status);
                    break;
                case 'pls_orders':
                    $data = $this->order_status_change_triggers($data, $old_status);
                    break;
                case 'pls_users':
                    $data = $this->user_status_change_triggers($data, $partner_id);
                    break;
            }
        }
        return $data;
    }


    /**
     * Partner status change triggers
     */
    private function partner_status_change_triggers($data)
    {
        if ($data['status'] == STATUS_DRAFT) {
            $data['status'] = PARTNER_STATUS_ACTIVE;
        }
        elseif ($data['status'] != PARTNER_STATUS_ACTIVE) {
            $this->CI->load->model('admin/Orders_model', 'orders_model');
            $partner_admins = $this->CI->partner_admins_model->get_partner_admins_domino($data['partner_id']);
            $partner_orders = $this->CI->orders_model->get_partner_orders_domino($data['partner_id']);
            $status = $this->get_partner_related_statuses($data['status']);
            if ($status) {
                $this->change_statuses($partner_admins, 'pls_users', 'user_id', $status['admin']);
                $this->change_statuses($partner_orders, 'pls_orders', 'order_id', $status['order']);
                if ($this->message_type) {
                    $this->CI->messages_model->save_message($data['partner_id'], 'partner', $this->message, $this->message_type);
                }
            }
        }
        return $data;
    }


    /**
     * Order status change triggers
     */
    private function order_status_change_triggers($data, $old_status)
    {
        if ($data['status'] == ORDER_STATUS_APPROVED) {
            
        }
        elseif ($data['status'] == STATUS_DRAFT) {
            $data['status'] = ORDER_STATUS_APPROVED;
        }

        //change status of original orders
        $original_order = $this->CI->orders_model->load_original($data['order_id'], $this->CI->lang->default_lang, FALSE);
        if ($original_order) {
            $original_order_data = ['status' => $data['status']];
            $original_order_data['order_id'] = $original_order->order_id;
            $this->CI->orders_model->save($original_order_data);
        }
        return $data;
    }


    /**
     * Partner admin status change triggers
     */
    private function user_status_change_triggers($data, $partner_id)
    {
        $this->CI->load->model('admin/Partners_model', 'partners_model');
        $partner = $this->CI->partners_model->load($partner_id);
        if ($partner && $partner->status == STATUS_DRAFT) {
            $data['status'] = STATUS_DRAFT;
        }
        elseif ($partner && $partner->status != PARTNER_STATUS_ACTIVE) {
            $data['status'] = STATUS_INACTIVE;
        }
        return $data;
    }


    private function get_partner_related_statuses($status)
    {
        $statuses = [];
        if ($status == PARTNER_STATUS_ACTIVE) {
            $statuses['admin'] = STATUS_ACTIVE;
            $statuses['order'] = ORDER_STATUS_APPROVED;
        }
        elseif ($status == PARTNER_STATUS_INACTIVE) {
            $statuses['admin'] = STATUS_INACTIVE;
            $statuses['order'] = ORDER_STATUS_INACTIVE;
            $this->message_type = 'inactivate';
            $this->message = lang('status_message_partner_deactivated');
        }
        elseif ($status == PARTNER_STATUS_CANCELLED) {
            $statuses['admin'] = STATUS_INACTIVE;
            $statuses['order'] = ORDER_STATUS_CANCELLED;
        }
        elseif ($status == PARTNER_STATUS_EXPIRED) {
            $statuses['admin'] = STATUS_INACTIVE;
            $statuses['order'] = ORDER_STATUS_EXPIRED;
            $this->message_type = 'expire';
            $this->message = lang('status_message_partner_expired');
        }
        return $statuses;
    }


    /**
     * Batch update statuses of related items
     */
    private function change_statuses($data, $table, $id, $status)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $data[$key]['status'] = $status;
            }
            $this->CI->db->update_batch($table, $data, $id);
        }
    }


    private function partner_delete_triggers($data)
    {
        $this->CI->load->model('admin/Partner_admins_model', 'admins_model');
        $this->CI->load->model('admin/Orders_model', 'orders_model');
        $this->CI->load->model('admin/Offers_model', 'offers_model');
        $this->CI->load->model('Locations_model', 'locations_model');
        //delete admins
        $partner_admins = $this->CI->admins_model->get_partner_admins_domino($data['partner_id']);
        $this->delete_items($partner_admins, 'pls_users', 'user_id');
        //delete orders
        $partner_orders = $this->CI->orders_model->get_partner_orders_domino($data['partner_id']);
        $this->delete_items($partner_orders, 'pls_orders', 'order_id');
        //delete offers
        $partner_offers = $this->CI->offers_model->get_partner_offers_domino($data['partner_id']);
        $this->delete_items($partner_offers, 'pls_offers', 'offer_id');
        //delete locations
        $partner_locations = $this->CI->locations_model->get_partner_locations_domino($data['partner_id']);
        $this->delete_items($partner_locations, 'pls_post_locations', 'location_id');
        return TRUE;
    }


    private function order_delete_triggers($data)
    {
        //delete original orders
        $original_order = $this->CI->orders_model->load_original($data['order_id'], $this->CI->lang->default_lang, FALSE);
        if ($original_order) {
            $original_order_data = $data;
            $original_order_data['order_id'] = $original_order->order_id;
            $this->CI->orders_model->save($original_order_data);
//            //delete original order offers
//            $order_offers = $this->CI->offers_model->get_order_offers_domino($original_order->order_id);
//            $this->delete_items($order_offers, 'pls_offers', 'offer_id');
//            //delete original order locations
//            $order_location = $this->CI->locations_model->get_order_locations_domino($original_order->order_id);
//            $this->delete_items($order_location, 'pls_post_locations', 'location_id');
        }
//        //delete offers
//        $order_offers = $this->CI->offers_model->get_order_offers_domino($data['order_id']);
//        $this->delete_items($order_offers, 'pls_offers', 'offer_id');
//        //delete locations
//        $order_location = $this->CI->locations_model->get_order_locations_domino($data['order_id']);
//        $this->delete_items($order_location, 'pls_post_locations', 'location_id');
        return $data;
    }

    /**
     * Delete original offer
     */
    private function offer_delete_triggers($data)
    {
        $original_offer = $this->CI->offers_model->load_original($data['offer_id']);
        if ($original_offer && !isset($this->CI->partner)) {
            $original_offer_data = $data;
            $original_offer_data['offer_id'] = $original_offer->offer_id;
            $this->CI->offers_model->save($original_offer_data);
        }
    }

    /**
     * Delete original location
     */
    private function location_delete_triggers($data)
    {
        $original_location = $this->CI->locations_model->load_original($data['location_id']);
        if ($original_location) {
            $original_location_data = $data;
            $original_location_data['location_id'] = $original_location->location_id;
            $this->CI->locations_model->save($original_location_data);
        }
    }


    /**
     * Batch delete related items
     */
    private function delete_items($data, $table, $id)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $data[$key]['is_deleted'] = 1;
                $data[$key]['deleted_by'] = $this->user_id;
                $data[$key]['deleted_at'] = date('Y-m-d H:i:s');
            }
            $this->CI->db->update_batch($table, $data, $id);
        }
    }
}
