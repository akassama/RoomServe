<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Orders_model extends PLS_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_orders';
        $this->table_translation = 'pls_orders_translations';
    }


    public function get_all_partner_orders($partner_id = NULL){
        $options['as_array'] = TRUE;
        if($partner_id) $options['where']['partner_id'] = $partner_id;
        $options['where']['status <>'] = STATUS_DRAFT;
        $options['where']['draft_order_id <>'] = 0;
        $options['where']['is_deleted'] = 0;
        $options['where']['vt.lang'] = $this->lang->get_current_lang();

        $options['join'][] = [
            'table' => 'pls_orders_translations as vt',
            'where' => 'vt.order_id = pls_orders.order_id',
            'type'  => 'left'
        ];
        $options['order_by']['key'] = 'vt.name';
        $options['order_by']['direction'] = 'ASC';
        $result = $this->get_list($options);
        return $result;
    }


    /**
     * Save opening hours info
     * @param int $order_id
     * @param array $opening_hours
     * @return bool Returns TRUE if saved successfully or FALSE otherwise
     */
    function save_order_opening_hours($order_id, $opening_hours)
    {
        if ($opening_hours && is_array($opening_hours)) {
            $days = [];
            foreach ($opening_hours as $key => $value) {
                $day['order_id'] = $order_id;
                $day['day'] = $value['day'];
                if (isset($value['work'])) {
                    $day['open_time'] = date("H:i", strtotime($value['open_time']));
                    $day['close_time'] = date("H:i", strtotime($value['close_time']));
                    $day['work'] = 1;
                }
                else {
                    $day['open_time'] = NULL;
                    $day['close_time'] = NULL;
                    $day['work'] = 0;
                }
                $days[] = $day;
            }
            $this->db->where(['type_id' => $order_id, 'type' => 'order'])->delete('pls_post_opening_hours');
            $this->db->insert_batch('pls_post_opening_hours', $days);
        }
    }


    /**
     * Load opening hours info
     * @param int $order_id
     * @return array Returns TRUE if saved successfully or FALSE otherwise
     */
    function get_order_opening_hours($order_id)
    {
        $this->db->select('day, open_time, close_time, work');
        $this->db->where(['type_id' => $order_id, 'type' => 'order']);
        $opening_hours = $this->db->get('pls_post_opening_hours')->result_array();
        $days = [];
        foreach ($opening_hours as $key => $value) {
            $days[$value['day']]['work'] = $value['work'];
            if ($value['work']) {
                $days[$value['day']]['open_time'] = date("h:i A", strtotime($value['open_time']));
                $days[$value['day']]['close_time'] = date("h:i A", strtotime($value['close_time']));
            }
        }
        return $days;
    }


    /*
    * Check order is original or draft
    */
    public function is_order_original($order_id)
    {
        $result = FALSE;
        $this->db->select('draft_order_id');
        $this->db->where(['is_deleted' => 0, 'order_id' => $order_id]);
        $order = $this->db->get($this->table)->row();
        if ($order && $order->draft_order_id) {
            $result = TRUE;
        }
        return $result;
    }
}
