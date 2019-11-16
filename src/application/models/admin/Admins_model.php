<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends Admin_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'pls_users';
    }


    /**
    * Grid list criteria
    */
    private function _list_options($options)
    {
        //$options['where']['pls_users.user_role_id'] = USER_ROLE_ADMINISTRATOR;
        $options['where']['pls_users.status !='] = STATUS_DRAFT;
        $options['where']['pls_users.is_deleted'] = 0;

        $options['join'][] = [
            'table' => 'pls_users_groups_rel',
            'where' => 'pls_users_groups_rel.user_id = pls_users.user_id',
            'type' => 'left'
        ];
        
       // $options['group_by'] = isset($options['group_by'])?$options['group_by']:['pls_users.user_id'];
        
        return $options;
    }


    /**
     * Count all admins in db
     */
    public function get_grid_count($options)
    {
        $options = $this->_list_options($options);

        return $this->count_all($options);
    }


    /**
     * Get admin list based on criteria
     */
    public function get_grid_list($options)
    {
        $options = $this->_list_options($options);
        $options['as_array'] = TRUE;


        $options['join'][] = [
            'table' => 'pls_users_groups',
            'where' => 'pls_users_groups.user_group_id = pls_users_groups_rel.user_group_id',
            'type' => 'left'
        ];

        $result = $this->get_list($options);
        if ($result) {
            foreach ($result as $key => $item) {
                if (isset($result[$key]['photo']) && $result[$key]['photo']) {
                    $result[$key]['photo'] = encrypt_file_url($result[$key]['photo']);
                }
            }
        }
        return $result;
    }
    

    public function get_analytics_info($options)
    {
        //вынужден использовать alias
        $options['where']['pls_users.user_role_id'] = USER_ROLE_ADMINISTRATOR;
        $options['where']['pls_users.status !='] = STATUS_DRAFT;
        $options['where']['pls_users.is_deleted'] = 0;
        
        
        $options['join'][] = [
            'table' => 'pls_users_groups_rel',
            'where' => 'pls_users_groups_rel.user_id = pls_users.user_id',
            'type' => 'left'
        ];
        
        switch($options['type']){
            
            case 'partners':
                $options['join'][] = [
                    'table' => 'pls_partners as target_table',
                    'where' => 'target_table.created_by = pls_users.user_id',
                    'type'  => 'inner',
                ];
                $options['where']['target_table.status <>'] = STATUS_DRAFT;
                $options['where']['target_table.is_deleted'] = 0;
            break;
            case 'orders':
                $options['join'][] = [
                    'table' => 'pls_orders as target_table',
                    'where' => 'target_table.created_by = pls_users.user_id',
                    'type'  => 'inner',
                ];
                $options['where']['target_table.is_deleted'] = 0;
                $options['where']['target_table.status <>'] = STATUS_DRAFT;
                $options['where']['target_table.draft_order_id <>'] = 0;
            break;
            case 'offers':
                $options['join'][] = [
                    'table' => 'pls_offers as target_table',
                    'where' => 'target_table.created_by = pls_users.user_id',
                    'type'  => 'inner',
                ];
                $options['where']['target_table.is_deleted'] = 0;
                $options['where']['target_table.status <>'] = STATUS_DRAFT;
                $options['where']['target_table.status <>'] = OFFER_STATUS_PENDING;
                $options['where']['target_table.draft_offer_id <>'] = 0;
            break;
            case 'locations':
                $options['join'][] = [
                    'table' => 'pls_post_locations as target_table',
                    'where' => 'target_table.created_by = pls_users.user_id AND target_table.type = "order"',
                    'type'  => 'inner',
                ];
                $options['where']['target_table.status <>'] = STATUS_DRAFT;
            break;
        }
        $options['group_by'] = isset($options['group_by'])?$options['group_by']:['pls_users.user_id'];
        $options['as_array'] = TRUE;
        
        return $this->get_list($options);
    }

    
}
