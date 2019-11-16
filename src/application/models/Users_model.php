<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends PLS_model
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'pls_users';
    }

    /**
     * Load user by user_id
     * @param int $id
     * @param int $role
     * @return object Returns user model object.
     */
    function load($id, $role = null)
    {
        if($role) {
            $this->db->where(['user_role_id' => $role]);
        }
        //getting partner admins title
        if ($role == USER_ROLE_PARTNER_ADMINISTRATOR) {
            $this->db->select('pls_users.*');
        }
        $this->db->where([
            'pls_users.user_id' => $id
        ]);
        $user = $this->db->get($this->table)->row();
        if ($user) {
            $user->photo = ($user->photo)?encrypt_file_url($user->photo):'';
        }
        return $user;

    }

    /**
     * Creates new user or updates user if user_id provided
     * @param array $data User data
     * @return bool Indicates user is created successfully or not.
     */
    function save($data, $test = false)
    {

        if (isset($data['date_of_birth'])) {
            $data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));
        }
        if (isset($data['user_id'])) {
            $data = $this->pls_crud_lib->updated($this->table, $data);
            if($this->db->update($this->table, $data, 'user_id = '.$data['user_id'])) {
                $result = $data['user_id'];
            }
        }
        else {
            //$data = $this->pls_crud_lib->created($this->table, $data);
            if($this->db->insert($this->table, $data)){
                $result = $this->db->insert_id();
            }
        }

        if($test){
            return $result;
        }

        return $result;
    }


    function save_user_group_connection($user_id, $group_id)
    {
        $this->delete_user_group_connection($user_id);
        $data['user_id'] = $user_id;
        $data['user_group_id'] = $group_id;
        $data = $this->pls_crud_lib->created('pls_users_groups_rel', $data, FALSE);
        return $this->db->insert('pls_users_groups_rel', $data);
    }


    function delete_user_group_connection($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->delete('pls_users_groups_rel');
    }


    function get_role_id_by_name($name)
    {
        $this->db->select('user_role_id');
        $this->db->where('name', $name);
        $role = $this->db->get('pls_users_roles');
        if ($role->num_rows()>0) {
            return $role->row()->user_role_id;
        }
        return FALSE;
    }


    public function get_user_by_role($user_id, $role_name)
    {
        $this->db->where([
            'is_deleted'   => 0,
            'pls_users.user_id' => $user_id,
            'pls_users_roles.name' => $role_name
        ]);
        //getting partner admins title
        if ($role_name == USER_ROLE_NAME_PARTNER_ADMINISTRATOR) {
            $this->db->select('pls_users.*, pls_users_roles.name, user_title as title');
        }

        $this->db->join('pls_users_roles', 'pls_users_roles.user_role_id = pls_users.user_role_id');
        $user = $this->db->get($this->table)->row();
        if ($user)
            $user->photo = ($user->photo)?encrypt_file_url($user->photo):'';
        return $user;
    }


    public function get_full_user_info_by_id($user_id, $admin = TRUE)
    {
        $fields = 'pls_users.user_id, photo, first_name, last_name, email, user_role_id, 1 as group_id, "" as group_name';
        // $fields = 'pls_users.user_id, photo, first_name, last_name, email, user_role_id, groups.user_group_id as group_id, groups.name as group_name';
        $this->db->select($fields);
        $this->db->where([
            'pls_users.user_id' => $user_id,
            //'groups.status'     => 1
        ]);
        // $this->db->join('pls_users_groups_rel as ugr', 'ugr.user_id = pls_users.user_id');
        // $this->db->join('pls_users_groups as groups', "groups.user_group_id = ugr.user_group_id");
        $user = $this->db->get($this->table)->row();

        if ($user && $user->photo) {
            $user->photo = encrypt_file_url($user->photo);
        }

        return $user;
    }


    public function get_user_by($options, $email_check = FALSE)
    {
        if ($email_check) {
            $this->db->select('pls_users.user_id, first_name, last_name, name as user_role');
            $this->db->join('pls_users_roles', 'pls_users_roles.user_role_id = pls_users.user_role_id', 'left');
        }
        else {
            $this->db->select('user_id, first_name, last_name, email, user_role_id, status, is_deleted');
        }
        $this->db->where('is_deleted', 0);
        $this->db->where('status <>', STATUS_DRAFT);
        $user = $this->db->where($options)->get('pls_users')->row();
        return $user;
    }



    /**
     * Check email uniqueness for form validation
     */
    public function check_email_uniqueness($email)
    {
        $this->db->where([
            'email'      => $email,
            'is_deleted' => 0,
            'status <>'  => STATUS_DRAFT,
        ]);
        if ($this->db->get($this->table)->num_rows() > 0) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Count all users in db
     */
    public function get_grid_count($options)
    {
        $options = $this->_list_options($options);

        return $this->count_all($options);
    }

    /**
     * Grid list criteria
     */
    private function _list_options($options)
    {
        $options['where']['pls_users.status !='] = STATUS_DRAFT;
        $options['where']['pls_users.is_deleted'] = 0;

        $options['join'][] = [
            'table' => 'pls_users_groups_rel',
            'where' => 'pls_users_groups_rel.user_id = pls_users.user_id',
            'type' => 'left'
        ];

        $options['group_by'] = isset($options['group_by'])?$options['group_by']:['pls_users.user_id'];

        return $options;
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

}
