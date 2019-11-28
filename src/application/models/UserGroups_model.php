<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserGroups_model extends PLS_model
{
    function __construct()
    {
        parent::__construct();

        $this->table = 'pls_users_groups';
    }


    /**
    * Grid list criteria
    */
    private function _list_options($options)
    {
        if (isset($this->partner->partner_id)) {
            $options['where']['pls_partners_groups_rel.partner_id'] = $this->partner->partner_id;
            $options['join'][] = [
                'table' => 'pls_partners_groups_rel',
                'where' => 'pls_partners_groups_rel.user_group_id = pls_users_groups.user_group_id',
                'type' => 'left'
            ];
        }
        $options['where']['pls_users_groups.status !='] = STATUS_DRAFT;
        $options['where']['pls_users_groups.is_deleted'] = 0;
        $options['where']['pls_users_groups.type'] = $type;
        $options['join'][] = [
            'table' => 'pls_users_groups_rel',
            'where' => 'pls_users_groups_rel.user_group_id = pls_users_groups.user_group_id',
            'type' => 'left'
        ];
        $options['group_by'] = 'pls_users_groups.user_group_id';

        return $options;
    }


    /**
     * Count all usergroups in db
     */
    public function get_grid_count($options)
    {
        $options = $this->_list_options($options, $type);

        return $this->count_all($options);
    }


    /**
     * Get user groups based on criteria
     */
    public function get_grid_list($options)
    {
        $options = $this->_list_options($options);

        $options['as_array'] = TRUE;

        $options['join'][] = [
            'table' => 'pls_users',
            'where' => 'pls_users.user_id = pls_users_groups_rel.user_id
                            and pls_users.status !="'.STATUS_DRAFT.'"
                            and pls_users.is_deleted = 0',
            'type' => 'left'
        ];

        return $this->get_list($options);
    }


    /**
     * Get partner related user groups based on criteria
     */
    public function partner_groups_list($options)
    {
        $options = $this->_list_options($options, 'partner');

        $options['as_array'] = TRUE;
        $options['join'][] = [
            'table' => 'pls_users',
            'where' => 'pls_users.user_id = pls_users_groups_rel.user_id
                            and pls_users.status !="'.STATUS_DRAFT.'"
                            and pls_users.is_deleted = 0',
            'type' => 'left'
        ];

        return $this->get_list($options);
    }


    /**
    * Loads group with its permissions
    * @param int $id Group id
    * @return array Returns group object and permission name.
    */
    public function load($id, $type = 'admin')
    {
        $this->db->select('name, status, pls_users_groups.user_group_id');
        $this->db->where([
            'pls_users_groups.user_group_id' => $id,
            'type' => $type,
        ]);
        if ($type == 'partner') {
            $this->db->where([
                'pls_partners_groups_rel.partner_id' => $this->partner->partner_id
            ]);
        }
        $this->db->join('pls_partners_groups_rel', 'pls_partners_groups_rel.user_group_id = pls_users_groups.user_group_id', 'left');
        return $this->db->get($this->table)->row();
    }


    /**
     * Creates new user group or updates user group info if user_group_id provided
     * @param array $data User data
     * @return bool Indicates user is created successfully or not.
     */
    function save($data)
    {
        if (isset($data['group']['user_group_id'])) {
            $this->db->where('user_group_id', $data['group']['user_group_id']);
            $data['group'] = $this->pls_crud_lib->updated($this->table, $data['group']);
            $result = $this->db->update($this->table, $data['group']);
            $group_id = $data['group']['user_group_id'];
            if (!$this->delete_permission_connections($group_id)) {
                return FALSE;
            }
        }
        else {
            $data['group'] = $this->pls_crud_lib->created($this->table, $data['group']);
            if($this->db->insert($this->table, $data['group'])){
                $result = $group_id = $this->db->insert_id();
            }
        }
        if (isset($data['permissions'])) {
            if (!$this->save_permission_connections($group_id, $data['permissions'])) {
                return FALSE;
            }
        }
        return $result;
    }


    /**
     * Get permission id by its name
     * @param string $name User group id
     * @return int permission_id
     */
    public function get_permission_id_by_name($name)
    {
        if ($name) {
            $this->db->select('user_permission_id');
            $this->db->where('name', $name);
            $permission = $this->db->get('pls_users_permissions')->row();
            if ($permission) {
                return $permission->user_permission_id;
            }
        }
        return FALSE;
    }

    /**
     * Get all permissions with modules
     * @return array permission list
     */
    public function get_all_perms($type = 'admin')
    {
        $perms = [];
        $this->db->select('name, module');
        $this->db->where('type', $type);
        $this->db->order_by('module', 'ASC');
        $this->db->order_by('user_permission_id', 'ASC');
        $all = $this->db->get('pls_users_permissions')->result_array();
        foreach ($all as $item) {
            $perms[$item['module']][] = $item['name'];
        }
        return $perms;
    }

    /**
     * Get all User groups
     * @return array Group list
     */
    public function get_all_groups($super_admin_group = FALSE)
    {
        $groups = [];
        $this->db->select('name, user_group_id');
        $this->db->where(['type' => 'admin', 'is_deleted' => 0, 'status' => STATUS_ACTIVE]);
        $this->db->order_by('name', 'ASC');
        $all = $this->db->get($this->table)->result_array();
        foreach ($all as $item) {
            if ($super_admin_group || $item['user_group_id'] != SUPER_ADMINISTRATOR_GROUP) {
                $gitem['key'] = $item['user_group_id'];
                $gitem['val'] = $item['name'];
                $groups[] = $gitem;
            }
        }
        return $groups;
    }


    /**
     * Get all Partner related groups
     * @return array Group list
     */
    public function get_all_partner_groups($partner_id, $partner_super_admin = FALSE)
    {
        $groups = [];
        $this->db->select('name, pls_users_groups.user_group_id');
        $this->db->where([
            'type' => 'partner',
            'is_deleted' => 0,
            'status' => STATUS_ACTIVE,
            'pg.partner_id' => $partner_id
        ]);
        if ($partner_super_admin) {
            $this->db->or_where('pls_users_groups.user_group_id', PARTNER_SUPER_ADMIN_GROUP);
        }
        $this->db->join('pls_partners_groups_rel as pg', 'pg.user_group_id = pls_users_groups.user_group_id', 'left');
        $this->db->order_by('name', 'ASC');
        $all = $this->db->get($this->table)->result_array();
        foreach ($all as $item) {
            $gitem['key'] = $item['user_group_id'];
            $gitem['val'] = $item['name'];
            $groups[] = $gitem;
        }
        return $groups;
    }


    /**
     * Get User group
     * @param int User id
     * @return int User group id
     */
    public function get_user_group_id($user_id)
    {
        $this->db->select('user_group_id');
        $this->db->where('user_id', $user_id);
        $row = $this->db->get('pls_users_groups_rel')->row();
        if ($row) {
            return $row->user_group_id;
        }
        return FALSE;
    }


    /**
     * Get User group name
     * @param int User group id
     * @return string User group name
     */
    public function get_user_group_name($user_id)
    {
        $this->db->select('ug.name');
        $this->db->join('pls_users_groups as ug', "ug.user_group_id = ugr.user_group_id");
        $this->db->where('user_id', $user_id);
        $this->db->from('pls_users_groups_rel as ugr');
        $row = $this->db->get()->row();
        if ($row) {
            return $row->name;
        }
        return '';
    }


    /**
     * Get permissions by group id
     * @return array permission list
     */
    public function get_group_perms($group_id)
    {
        $perms = [];
        $this->db->select('p.name');
        $this->db->where('user_group_id', $group_id);
        $this->db->join('pls_users_permissions as p', 'p.user_permission_id = gp.user_permission_id');
        $all = $this->db->get('pls_users_groups_permissions_rel as gp')->result_array();
        foreach ($all as $item) {
            $perms[] = $item['name'];
        }
        return $perms;
    }


    /**
     * Checks if group has specific permission
     * @return bool If group has permission returns TRUE
     */
    public function has_group_permission($group_id, $permission_id)
    {
        $this->db->where(array(
            'user_group_id' => $group_id,
            'user_permission_id' => $permission_id
        ));
        $numrow = $this->db->get('pls_users_groups_permissions_rel')->num_rows();
        if ($numrow > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
    * Save group and permission relations
    * @param int $group_id User group id
    * @param array $perms Permission list
    * @return bool Indicates group and permission relations is successfully updates or not.
    */
    private function save_permission_connections($group_id, $perms)
    {
        $perm_list = array_keys($perms);
        if ($perm_list) {
            $data = array('user_group_id'=>$group_id);
            foreach ($perm_list as $item) {
                $data['user_permission_id'] = $this->get_permission_id_by_name($item);
                if ($data['user_permission_id']) {
                    $data = $this->pls_crud_lib->created('pls_users_groups_permissions_rel', $data, FALSE);
                    $this->db->insert('pls_users_groups_permissions_rel', $data);
                }
            }
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Delete all group and permission relations by group id
     * @param int $group_id User group id
     * @return bool Indicates group and permission relations is successfully deletes or not.
     */
    private function delete_permission_connections($group_id)
    {
        $this->db->where('user_group_id', $group_id);
        return $this->db->delete('pls_users_groups_permissions_rel');
    }


    public function save_partner_group_connection($partner_id, $group_id)
    {
        $this->db->where([
            'user_group_id' => $group_id,
            'partner_id'    => $partner_id
        ]);
        $rows = $this->db->get('pls_partners_groups_rel')->num_rows();
        if (! $rows) {
            $data['user_group_id'] = $group_id;
            $data['partner_id'] = $partner_id;
            return $this->db->insert('pls_partners_groups_rel', $data);
        }
    }


    /**
     * Get permission module by its name
     * @param string $name User group id
     * @return string permission module
     */
    public function get_permission_module_by_name($name)
    {
        if ($name) {
            $this->db->select('module');
            $this->db->where('name', $name);
            $permission = $this->db->get('pls_users_permissions')->row();
            if ($permission) {
                return $permission->module;
            }
        }
        return FALSE;
    }


    public function count_users_in_group($group_id)
    {
        $this->db->where([
            'user_group_id' => $group_id,
            'pls_users.is_deleted' => 0
        ]);
        $this->db->join('pls_users', 'pls_users.user_id = pls_users_groups_rel.user_id', 'left');
        return $this->db->count_all_results('pls_users_groups_rel');

    }


    /**
     * Create new usergroup for newly created partner
     */
    public function create_usergroup_for_project($partner_id)
    {
        $this->db->select('name, type, status');
        $this->db->where('user_group_id', PATTERN_GROUP_ID);
        $pattern_group = $this->db->get($this->table)->row_array();
        $this->db->insert($this->table, $pattern_group);
        $new_group_id = $this->db->insert_id();
        $this->db->select('user_group_id, user_permission_id');
        $this->db->where('user_group_id', PATTERN_GROUP_ID);
        $group_perms = $this->db->get('pls_users_groups_permissions_rel')->result_array();
        foreach ($group_perms as $key => $value) {
            $group_perms[$key]['user_group_id'] = $new_group_id;
        }
        $this->db->insert_batch('pls_users_groups_permissions_rel', $group_perms);
        $this->save_partner_group_connection($partner_id, $new_group_id);
    }

}
