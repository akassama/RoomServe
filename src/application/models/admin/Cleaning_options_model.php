<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cleaning_options_model extends Admin_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_cleaning_options';
    }


    /**
    * Grid list criteria
    */
    private function _list_options($options)
    {
        $options['where']['pls_cleaning_options.is_deleted'] = 0;
        $options['where']['pls_cleaning_options.status !='] = STATUS_DRAFT;
        $options['group_by'] = ['pls_cleaning_options.option_id'];

        return $options;
    }


    /**
     * Count all categories in db
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

        $options['group_by'] = 'pls_cleaning_options.option_id';

        return $this->get_list($options);
    }


    /**
     * Creates new category or updates category if option_id provided
     * @param array $data User data
     * @return bool Indicates user is created successfully or not.
     */
    function save($data)
    {
        if (isset($data['option_id'])) {
            $data = $this->pls_crud_lib->updated($this->table, $data);
            $result = $this->db->update($this->table, $data, 'option_id = '.$data['option_id']);
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
     * Load categories by option_id
     * @param int $id
     * @return object Returns categories model object.
     */
    function load($id)
    {
        $this->db->where([
            'pls_cleaning_options.option_id' => $id
        ]);
        $category = $this->db->get($this->table)->row();

        return $category;
    }


    /**
     * Get all categories
     * @param string $type
     * @return object Returns all categories.
     */
    public function get_all_categories($type = NULL){
        $options['as_array'] = TRUE;
        $options['fields'] = 'pls_cleaning_options.option_id, name';
        $options['where']['status'] = STATUS_ACTIVE;

        $result = $this->get_list($options);
        return $result;
    }
}
