<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends Admin_Model
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
        $options['join'][] = [
            'table' => 'pls_orders_translations',
            'where' => 'pls_orders_translations.order_id = pls_orders.order_id and pls_orders_translations.lang = "'.$this->lang->default_lang.'"',
            'type'  => 'left'
        ];

        $options['join'][] = [
            'table' => 'pls_users',
            'where' => 'pls_users.user_id = pls_orders.created_by',
            'type' => 'left'
        ];
		
        $options['group_by'] = isset($options['group_by'])?$options['group_by']:['pls_orders.order_id'];

        return $options;
    }

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
            if (isset($data['order_date']))
                $data['order_date'] = date('Y-m-d', strtotime($data['order_date']));
            $data = $this->pls_crud_lib->updated($this->table, $data);
            $result = $this->db->update($this->table, $data, 'order_id = '.$data['order_id']);
        }
        else {
            $data = $this->pls_crud_lib->created($this->table, $data);
            if($this->db->insert($this->table, $data)){
                $result = $this->db->insert_id();
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
        if($this->load_translation($data['order_id'], $data['lang'])){
            $this->db->where('order_id', $data['order_id']);
            $this->db->where('lang', $data['lang']);
            $result = $this->db->update($this->table_translation, $data);
        }
        else {
            if($this->db->insert($this->table_translation, $data)){
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
        $this->db->select('pls_orders.*');
        if($lang) $this->db->select('vt.name, vt.description, vt.search_keywords, vt.lang');

        $this->db->where([
            'pls_orders.order_id' => $id,
            'pls_orders.is_deleted' => 0,
        ]);
        if ($only_draft) {
            $this->db->where(['pls_orders.draft_order_id' => 0]);
        }
        if($lang) $this->db->join('pls_orders_translations as vt', 'vt.order_id = pls_orders.order_id and vt.lang= "'.$lang.'"', 'left');
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
     * Load original order by draft order_id
     * @param $draft_id
     * @return mixed
     */
    function load_original($draft_order_id, $lang, $approved = TRUE){
        $this->db->select('pls_orders.*, vt.name, vt.description, vt.search_keywords, vt.lang');
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


    /**
     * Check is order pending approval
     */
    function pending_approval($id){
        $this->db->select('status');
        $order = $this->db->where(['order_id' => $id , 'draft_order_id' => 0])->get('pls_orders')->row();
        return ($order && $order->status == ORDER_STATUS_PENDING ? true : false);
    }


    /**
    * Get orders based on partner id
    */
    function get_partner_orders_domino($partner_id)
    {
        $this->db->select('order_id, status, is_deleted');
        $this->db->where([
            'partner_id' => $partner_id,
            'is_deleted' => 0,
            'status !=' => STATUS_DRAFT,
        ]);

        return $this->db->get('pls_orders')->result_array();
    }


    function get_partner_by_order($order_id){
        $this->db->select('partner_id');
        $this->db->where(['order_id' => $order_id]);
        $order =  $this->db->get('pls_orders')->row();
        return $order->student_id;
    }


    function create_order_copy($order_id){
        $order_data = $this->db->where(['pls_orders.order_id' => $order_id])->get($this->table)->row_array();
        unset($order_data['order_id']);
        $order_data['draft_order_id'] = $order_id;
        $order_original_data = $this->db->where(['pls_orders.draft_order_id' => $order_id])->get($this->table)->row_array();
        //check if existe original data, update original data else create copy draft to original
        if($order_original_data){
            $this->db->update($this->table, $order_data, 'order_id = '.$order_original_data['order_id']);
            $original_order_id = $order_original_data['order_id'];
            //delete old translation data
            $this->db->where('order_id', $order_original_data['order_id'])->delete('pls_orders_translations');
            

        }
        else {
            if ($this->db->insert($this->table, $order_data)) {
                $original_order_id = $this->db->insert_id();
            }
        }
        

        //copy translation to original
        $this->db->where(['pls_orders_translations.order_id' => $order_id]);
        $order_data_i18n = $this->db->get('pls_orders_translations')->result_array();
        foreach($order_data_i18n as $item){
            $item['order_id'] = $original_order_id;
            $this->db->insert('pls_orders_translations', $item);
        }

        
        return $original_order_id;
    }
}
