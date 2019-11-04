<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends Partner_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_orders';
        $this->table_translation = 'pls_orders_translations';
    }


    /**
     * Grid list criteria
    */
    private function _list_options($options)
    {
        $options['where']['pls_orders.is_deleted'] = 0;
        if (! isset($options['where']['pls_orders.draft_order_id'])) {
            $options['where']['pls_orders.draft_order_id <>'] = 0;
        }
        $options['where']['pls_orders.status <>'] = STATUS_DRAFT;
        $options['where']['pls_orders.student_id'] = $this->student->user_id;

        $options['join'][] = [
            'table' => 'pls_orders_translations',
            'where' => 'pls_orders_translations.order_id = pls_orders.order_id and pls_orders_translations.lang = "'.$this->lang->default_lang.'"',
            'type'  => 'left'
        ];
        $options['group_by'] = isset($options['group_by'])?$options['group_by']:['pls_orders.order_id'];

        return $options;
    }


    /**
     * Count all orders in db
     */
    public function get_grid_count($options)
    {
        $options = $this->_list_options($options);

        return $this->count_all($options);
    }


    /**
     * Get order list based on criteria
     */
    public function get_grid_list($options)
    {
        $options = $this->_list_options($options);

        $options['as_array'] = TRUE;

        $options['join'][] = [
            'table' => 'pls_cleaning_options',
            'where' => 'pls_cleaning_options.option_id = pls_orders.option_id',
            'type'  => 'left'
        ];

        $result =  $this->get_list($options);
        if ($result) {
            
        }
        return $result;
    }


    /**
     * Creates new user or updates user if user_id provided
     * @param array $data User data
     * @return bool Indicates user is created successfully or not.
     */
    function save($data)
    {
        if (isset($data['order_id'])) {
            $data['order_date'] = date('Y-m-d', strtotime($data['order_date']));
            $data = $this->pls_crud_lib->updated($this->table, $data);
            $result = $this->db->update($this->table, $data, 'order_id = '.$data['order_id']);
        }
        else {
            $data = $this->pls_crud_lib->created($this->table, $data);
            if($this->db->insert($this->table, $data)){
                $result = $user_id = $this->db->insert_id();
            }
        }
        return $result;
    }

    /**
     * Creates new order translation or update order if order_id provided
     * @param array $data Order translation data
     * @return bool Indicates user is created successfully or not.
     */
    function save_translation($data)
    {
        if ($this->load_translation($data['order_id'], $data['lang'])) {
            $this->db->where('order_id', $data['order_id']);
            $this->db->where('lang', $data['lang']);
            $result = $this->db->update($this->table_translation, $data);
        } else {
            if ($this->db->insert($this->table_translation, $data)) {
                $result = TRUE;
            }
        }

        return $result;
    }

    /**
     * Load order by order_id
     * @param int $id
     * @return object Returns orders model object.
     */
    function load($id, $lang = NULL, $only_draft = TRUE)
    {
        //if existe lang
        if($lang) $this->db->select('vt.name, vt.description, vt.search_keywords, vt.lang');
        $this->db->select('pls_orders.*');

        $this->db->where([
            'pls_orders.order_id' => $id,
            'pls_orders.is_deleted' => 0,
        ]);
        if ($only_draft) {
            $this->db->where(['pls_orders.draft_order_id' => 0]);
        }
        //if existe lang
        if($lang) $this->db->join('pls_orders_translations as vt', 'vt.order_id = pls_orders.order_id and vt.lang= "'.$lang.'"', 'left');

        //get
        $order = $this->db->get($this->table)->row();
        if ($order) {
            $order->order_date = ($order->order_date)?date('d F Y', strtotime($order->order_date)):date('d F Y');
        }
        return $order;
    }

    /**
     * Load orders translation by order_id
     * @param int $id
     * @return object Returns orders model object.
     */
    function load_translation($id, $lang)
    {
        $this->db->where([
            'pls_orders_translations.order_id' => $id,
            'pls_orders_translations.lang' => $lang
        ]);
        $order_trans = $this->db->get($this->table_translation)->row();
        return $order_trans;
    }

    /**
     * Create copy of order based on draft order
     */
    function create_order_copy($order_id){
        $order_data = $this->db->where(['pls_orders.order_id' => $order_id])->get($this->table)->row_array();
        $order_data['draft_order_id'] = $order_id;
        $order_data['status'] = ORDER_STATUS_PENDING;
        unset($order_data['order_id']);
        $order_original_data = $this->db->where(['pls_orders.draft_order_id' => $order_id])->get($this->table)->row_array();
        if ($order_original_data) {
            if ($order_original_data['status'] == ORDER_STATUS_DECLINED || $order_original_data['status'] == ORDER_STATUS_PENDING) {
                $order_data['reason_id'] = STATUS_REASON_VENUE_AWAITING_APPROVAL;
                $this->db->update($this->table, $order_data, 'order_id = ' . $order_original_data['order_id']);
                $original_order_id = $order_original_data['order_id'];
                $order_data['draft_order_id'] = 0;
                $this->db->update($this->table, $order_data, 'order_id = ' . $order_id);
                //delete old translation data
                $this->db->where('order_id', $original_order_id)->delete('pls_orders_translations');
                
            }
            else {
                $data['reason_id'] = $order_data['reason_id'];
                $this->db->update($this->table, $data, 'order_id = ' . $order_original_data['order_id']);
                return FALSE;
            }
        }
        else {
            if ($this->db->insert($this->table, $order_data)) {
                $original_order_id = $this->db->insert_id();
            }
            else {
                return FALSE;
            }
        }

    

        //copy other order info
        $this->update_order_info($order_id, $original_order_id);

        return $original_order_id;
    }


    /**
     * Reset draft order info
     */
    function reset_draft_order($order_id){
        $order_data = $this->db->where(['pls_orders.draft_order_id' => $order_id])->get($this->table)->row_array();
        $order_data['reason_id'] = 0;
        $order_data['draft_order_id'] = 0;
        $original_order_id = $order_data['order_id'];
        $order_data['order_id'] = $order_id;
        $this->db->update($this->table, $order_data, 'order_id = '.$order_id);
        //delete old translation data
        $this->db->where('order_id', $order_id)->delete('pls_orders_translations');
        
        //copy other order info
        $this->update_order_info($original_order_id, $order_id);

        return TRUE;
    }


    /**
     * Update order info like locations photos, tags in order to make the same
     */
    private function update_order_info($order_id, $copied_order_id)
    {
        //copy translations
        $this->db->where(['pls_orders_translations.order_id' => $order_id]);
        $order_data_i18n = $this->db->get('pls_orders_translations')->result_array();
        foreach($order_data_i18n as $item){
            $item['order_id'] = $copied_order_id;
            $this->db->insert('pls_orders_translations', $item);
        }

       
    }





    /**
     * Load original order by draft order_id
     * @param $draft_id
     * @return mixed
     */
    function load_original($draft_order_id, $lang, $approved = TRUE){
        $this->db->select('pls_orders.*, vt.name, vt.description, vt.search_keywords, vt.lang, pls_orders.status');
        $data = ['pls_orders.draft_order_id' => $draft_order_id];
        if ($approved) {
            $data['pls_orders.status'] = ORDER_STATUS_APPROVED;
        }
        $this->db->where($data);
        $this->db->join('pls_orders_translations as vt', 'vt.order_id = pls_orders.order_id and vt.lang= "'.$lang.'"', 'left');
        $order = $this->db->get($this->table)->row();
        if ($order) {
        }
        return $order;
    }

}
