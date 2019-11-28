<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Grid view generation Library
 *
 * @author     bzimor <bobzimor@gmail.com>
 * @version    1.2
 */
class Pls_grid_lib
{
    /**
     * All grid helper files and table name array
     * Add newly created grid helper name here
     */
    private $grids = array(
        'administrators'                    => ['grid/admin/administrators', 'pls_users'],
        'groups'                            => ['grid/admin/user_groups', 'pls_users_groups'],
        'orders'                            => ['grid/admin/orders', 'pls_orders'],
        'cleaning_options'                        => ['grid/admin/cleaning_options', 'pls_cleaning_options'],
        'payment_options'                        => ['grid/admin/payment_options', 'pls_payment_options'],
        'personal_options'                        => ['grid/admin/personal_options', 'pls_personal_options'],

        'order_student'                    => ['grid/student/orders', 'pls_orders'],
    );

    /**
     * Special table columns when used to order in Mysql
     */
    private $special_columns = [
        'created_at',
        'start_date',
        'end_date',

    ];

    /**
     * Grid array from helper
     */
    public $grid_array;

    /**
     * Database query options based on grid array and filters
     */
    public $db_options;

    /**
     * User permissions array
     */
    public $permissions;


    /**
     * Constructor
     */
    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();
        // make global variables empty
        $this->db_options = [];
        $this->permissions = [];
    }


    /**
     * Return grid_columns for ajax response
     */
    public function ajax_grid_columns($name, $api = NULL)
    {
        return $this->prepare_grid_columns($name, $api, TRUE);
    }

    /**
     * Return grid_columns for csv reports
     */
    public function csv_grid_columns($name, $api = NULL){
        $this->prepare_grid_columns($name, $api, TRUE);
        if ($this->filter_csv_columns()) {
            return $this->grid_array;
        }
        return FALSE;
    }

    /**
     * Return grid_columns for db query
     */
    function db_grid_columns($name, $ajax_post, $api = NULL, $quick_state_name = NULL, $date_format = '%d %b %Y')
    {
        if ($this->prepare_grid_columns($name, $api)) {
            //build limit and order options based on ajax request
            $this->table_options($ajax_post, $name);
            //get fields for db select query
            $this->db_options['fields'] = $this->get_grid_fields($date_format);
            //apply filters if exists
            if (isset($ajax_post['filter'])) {
                $this->table_filters($ajax_post['filter']);
            }

            //get quick stats columns options
            $this->db_options['quick_stats'] = $this->get_quick_stats_options($quick_state_name);
            return $this->db_options;
        }
        return FALSE;
    }


    /**
     * Set filter options for db query
     */
    private function table_filters($filters)
    {
        // get filter options array
        $filter_options = $this->filter_options();

        //build filters based on filter operators
        foreach ($filters as $key => $value) {
            if($filter_options[$key][2] == 'date')
                $value = date('Y-m-d', strtotime($value));

            $this->operator_handling($filter_options[$key][1],$filter_options[$key][0], $value, $this->db_options);
        }

    }

    /**
     * Get filter operators(like, =, <>) with field names as a key from helper
     */
    private function filter_options()
    {
        $filter_options = [];
        foreach ($this->grid_array['filters']['fields'] as $field) {

            $type = isset($field['type'])?$field['type']:"text";

            if($field['operator'] == 'range') {
                //if the dbfields are different
                $from_field = is_array($field['dbfield'])?$field['dbfield']['from']:$field['dbfield'];
                $to_field   = is_array($field['dbfield'])?$field['dbfield']['to']:$field['dbfield'];

                $filter_options['from-'.$field['name']] = [">=", $from_field, $type];
                $filter_options['to-'.$field['name']]   = ["<=", $to_field, $type];
            }
            else {
                $filter_options[$field['name']] = [$field['operator'], $field['dbfield'], $type];
            }
        }
        return $filter_options;
    }

    /**
     * Operators handling
     */
    private function operator_handling($field, $operator, $value, &$ref_return)
    {
            if ($operator == 'like') {
                $ref_return['like'][] = ['key' => $field, 'string' => $value];
            }
            elseif ($operator == 'in') {
                $ref_return['where_in'][$field] = $value;
            }
            else {
                $ref_return['where'][$field.$operator] = $value;
            }
    }

    /**
     * Initialize list state saved to database
     */
    private function initialize_table_state($module, $api)
    {
        $list_state = '';
        if ($api === NULL) {
        }
        else {
            $list_state = $api;
        }
        if ($list_state) {
            $list_state = json_decode($list_state, TRUE);
            $columns = array_flip(array_keys($list_state['columns']));
            $new_array = [];
            $unknown_columns = [];
            foreach ($this->grid_array['columns'] as $column) {
                if (isset($columns[$column['name']]) && (! isset($column['type']) || $column['type'] != 'actions')) {
                    $new_array[$columns[$column['name']]] = $column;
                    $new_array[$columns[$column['name']]]['visible'] = $list_state['columns'][$column['name']]['visible'];
                }
                else {
                    $unknown_columns[] = $column;
                }
            }
            $this->grid_array['columns'] = $new_array;
            if (count($unknown_columns) > 0) {
                foreach ($unknown_columns as $column) {
                    $this->grid_array['columns'][] = $column;
                }
            }

            if (isset($list_state['order']['column'])) {
                $this->grid_array['options']['order']['order_by'] = $list_state['order']['column'];
                $this->grid_array['options']['order']['order_dir'] = $list_state['order']['direction'];
            }
        }
    }

    /**
     * Set limit, offset and order options for db query
     */
    private function table_options($options, $name)
    {
        $this->db_options['limit']['start'] = !empty($options['start'])?$options['start']:NULL;
        $this->db_options['limit']['length'] = !empty($options['length'])?$options['length']:NULL;;
        if(!empty($options['order']))
        {

            if (in_array(trim($options['order'][0]['column']), $this->special_columns)) {
                $this->db_options['order_by']['key'] = $this->grids[$name][1].'.'.trim($options['order'][0]['column']);
            }
            else {
                $this->db_options['order_by']['key'] = $options['order'][0]['column'];
            }
            $this->db_options['order_by']['direction'] = $options['order'][0]['direction'];
        }

    }


    /**
     * Use filters for grid columns before passing it to ajax or db query
     */
    private function prepare_grid_columns($name, $api, $ajax = FALSE)
    {
        if (in_array($name, array_keys($this->grids))) {
            $this->grid_array = $this->get_helper_array($name);
            if ($ajax) {
                $this->initialize_table_state($name, $api);
                $this->filter_quick_stat_fields();
            }
            if ($api === NULL) {
                $this->check_csv_permission();
                $this->permissions = $this->CI->pls_auth_lib->user_permissions();
                $this->permission_filter_columns($ajax);
                $this->permission_filter_actions();
            }
            return $this->grid_array;
        }
        return FALSE;
    }


    /**
     * Filters grid fields based on permissions
     */
    private function permission_filter_columns($ajax)
    {
        foreach ($this->grid_array['columns'] as $key => $column) {
            if (isset($column['has_access'])) {
                $show = FALSE;
                if (is_array($column['has_access'])) {
                    foreach ($column['has_access'] as $perm) {
                        if (in_array($perm, $this->permissions)) {
                            $show = TRUE;
                        }
                    }
                }
                else{
                    if (in_array($column['has_access'], $this->permissions)) {
                        $show = TRUE;
                    }
                }
                // if (! $show) {
                //     unset($this->grid_array['columns'][$key]);
                // }
            }
            if ($ajax) {
                unset($this->grid_array['columns'][$key]['field']);
            }
        }
        if ($ajax && isset($this->grid_array['filters'])) {
            foreach ($this->grid_array['filters']['fields'] as $key => $filter) {
                if (isset($filter['dbfield'])) {
                    unset($this->grid_array['filters']['fields'][$key]['dbfield']);
                }
            }
        }
        if ($ajax && isset($this->grid_array['presets'])) {
            foreach ($this->grid_array['presets'] as $key => $value) {
                unset($this->grid_array['presets'][$key]['query']);
            }
        }
    }


    /**
     * Filters grid actions based on permissions
     */
    private function permission_filter_actions()
    {
        if (isset($this->grid_array['actions'][0]['has_access'])) {
            // foreach ( $this->grid_array['actions'] as $key => $action) {
            //     if (! in_array($action['has_access'], $this->permissions)) {
            //         unset($this->grid_array['actions'][$key]);
            //     }
            // }
        }
    }


    /**
     * Filters quick stats array fields
     */
    private function filter_quick_stat_fields()
    {
        if (isset($this->grid_array['quick_stats'])) {
            foreach ( $this->grid_array['quick_stats'] as $key => $value) {
                unset($this->grid_array['quick_stats'][$key]['group_by']);
                unset($this->grid_array['quick_stats'][$key]['fields']);
            }
        }
    }


    /**
     * Checks if user has access to export csv
     */
    private function check_csv_permission()
    {
        if (isset($this->grid_array['options']['csv']['has_access'])) {
            if (! has_permission($this->grid_array['options']['csv']['has_access'])) {
                $this->grid_array['options']['csv']['csv_export'] = FALSE;
            }
        }
    }


    /**
     * Filters grid columns based on csv
     */
    private function filter_csv_columns()
    {
        if (isset($this->grid_array['options']['csv']['csv_export']) && ! $this->grid_array['options']['csv']['csv_export']) {
            return FALSE;
        }
        foreach ( $this->grid_array['columns'] as $key => $column) {
            if (isset($column['csv']) && $column['csv'] === FALSE) {
                unset($this->grid_array['columns'][$key]);
            }
        }
        return TRUE;
    }


    /**
     * Get fields from grid array, if there is custom fields, build them with variables
     */
    private function get_grid_fields($date_format)
    {
        $select = '';
        foreach ($this->grid_array['columns'] as $value) {
            $value['field'] = str_replace('{{date_format}}', $date_format, $value['field']);
            $select .= $value['field'];
            $select .=', ';
        }
        if (isset($this->grid_array['additional_columns'])) {
            foreach ($this->grid_array['additional_columns'] as $value) {
                $select .= $value['field'];
                $select .=', ';
            }
        }
        $select = substr($select, 0, -2);
        return $select;
    }


    /**
    * Loads specific validation helper, stores form field names and return rules array
    * @param string $name
    */
    private function get_helper_array($name)
    {
        $this->CI->load->helper($this->grids[$name][0]);
        $myfunc = $name.'_grid_columns';
        try{
            $grid = $myfunc();
        }
        catch(Exception $e){
            return FALSE;
        }
        return $grid;
    }


    /**
     * Returns common options and specials options array for each stats column
     */
    private function get_quick_stats_options($quick_state_name)
    {
        $options = [];
        $additional_options = $this->db_options;

        if(isset($this->grid_array['quick_stats'])) {
            foreach ($this->grid_array['quick_stats'] as $stat) {
                $stat_options = [];
                $stat_options['group_by'] = $stat['group_by'];
                foreach($stat['fields'] as $field) {
                    $this->operator_handling($field['dbfield'], $field['operator'], $field['value'], $stat_options);
                }
                $options[$stat['name']] = array_merge_recursive($additional_options, $stat_options);
                if ($stat['name'] == $quick_state_name) {

                    foreach($stat['fields'] as $field) {
                        //this is for filtering datatable
                        $this->operator_handling($field['dbfield'], $field['operator'], $field['value'], $this->db_options);
                    }
                }
            }
        }
        return $options;
    }
}
