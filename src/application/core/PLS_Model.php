<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PLS_Model extends CI_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks if row exists based on options
     * @param array $options Filters to use WHERE clause
     * @return bool Returns TRUE if row exists in db
     * */
    public function exists($options)
    {
        $this->db->where($options);
        $num = $this->db->get($this->table)->num_rows();
        if($num == 0){return FALSE;}
        else {return TRUE;}
    }


    /**
     * Count rows based on $options
     */
    protected function count_all($options)
    {
        $this->db->distinct();
        if(isset($options['where'])) {
            $this->db->where($options['where']);
        }
        if(isset($options['where_in'])) {
            foreach ($options['where_in'] as $key => $value) {
                $this->db->where_in($key, $value);
            }
        }
        if(isset($options['or_where'])) {
            $this->db->or_where($options['where']);
        }
        if(isset($options['where_no_escape'])) {
            $this->db->where($options['where_no_escape'],NULL, FALSE);
        }
        if(isset($options['like'])){
            foreach ($options['like'] as $option) {
                $this->db->like($option['key'], $option['string'], 'both');
            }
        }

        if(isset($options['join'])) {
            foreach ($options['join'] as $option) {
                $this->db->join($option['table'], $option['where'], $option['type']);
            }
        }
        if (isset($options['group_by'])) {
            $this->db->group_by($options['group_by']);
        }
        return $this->db->get($this->table)->num_rows();
    }


    protected function isEmpty($value)
    {
        return $value === '' || $value === [] || $value === null || is_string($value) && trim($value) === '';
    }

    //get array list of certain table rows based on criterias
    public function get_list($options)
    {
        if(isset($options['fields'])) {
            $this->db->select($options['fields']);
        }
        if(isset($options['where'])) {
            $this->db->where($options['where']);
        }
        if(isset($options['or_where'])) {
            $this->db->or_where($options['where']);
        }
        if(isset($options['where_in'])) {
            foreach ($options['where_in'] as $key => $value) {
                $this->db->where_in($key, $value);
            }
        }
        if(isset($options['where_not_in'])) {
            foreach ($options['where_not_in'] as $key => $value) {
                $this->db->where_not_in($key, $value);
            }
        }
        if(isset($options['where_no_escape'])) {
            $this->db->where($options['where_no_escape'],NULL, FALSE);
        }
        if(isset($options['like'])){
            foreach ($options['like'] as $option) {
                $this->db->like($option['key'], $option['string'], 'both');
            }
        }
        if(isset($options['limit'])) {
            $offset = (isset($options['limit']['start'])) ? $options['limit']['start'] : NULL;
            $this->db->limit($options['limit']['length'], $offset);
        }
        if(isset($options['join'])) {
            foreach ($options['join'] as $option) {
                $this->db->join($option['table'], $option['where'], $option['type']);
            }
        }
        if(isset($options['order_by'])){
            $this->db->order_by($options['order_by']['key'], $options['order_by']['direction']);
        }
        if (isset($options['group_by'])) {
            $this->db->group_by($options['group_by']);
        }
        if(isset($options['as_array']) && $options['as_array']==true) {
            return $this->db->get($this->table)->result_array();
        }
        return $this->db->get($this->table)->result();
    }


    public function decrypt_user_info($data)
    {
        if (is_array($data)) {
            $decrypted_fields = ['first_name', 'last_name', 'email', 'date_of_birth', 'staff_group'];
            foreach ($data as $key => $value) {
                if (in_array($key, $decrypted_fields)) {
                    $data[$key] = decrypt_user_info($data[$key]);
                }
            }
        }
        elseif (is_object($data)) {
            if (isset($data->first_name)) {
                $data->first_name = decrypt_user_info($data->first_name);
            }
            if (isset($data->last_name)) {
                $data->last_name = decrypt_user_info($data->last_name);
            }
            if (isset($data->email)) {
                $data->email = decrypt_user_info($data->email);
            }
            if (isset($data->date_of_birth)) {
                $data->date_of_birth = decrypt_user_info($data->date_of_birth);
            }
            if (isset($data->staff_group)) {
                $data->staff_group = decrypt_user_info($data->staff_group);
            }
        }
        return $data;
    }
}



class Admin_Model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
    }

}

class Partner_Model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
    }
}


class Member_Model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
    }

}


class Global_Orders_Model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
    }
}


class Global_Offers_Model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
    }
}
