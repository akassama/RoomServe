<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students_model extends Partner_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_users';
    }


    /**
     * Load partner by partner_id
     * @param int $id
     * @return object Returns partner model object.
     */
    function load($id)
    {
        $this->db->where([
            'user_id' => $id,
            'is_deleted' => 0,
        ]);
        $partner = $this->db->get($this->table)->row();
        if ($partner) {
        }

        return $partner;
    }


    public function student_matchs($student_id)
    {
        $this->db->where(['user_id' => $student_id, 'is_deleted' => 0]);
        $partner = $this->db->get('pls_users')->row();
        if (! $partner) {
            return FALSE;
        }
        else {
            if (! $this->pls_auth_lib->is_admin()) {
                return TRUE;
            }
            return TRUE;
        }
    }


    /**
     * Get partner based on partner admin id
     */
    public function get_partner_by_user_id($user_id)
    {
        $this->db->select('p.partner_id, p.name, p.logo');
        $this->db->where([
            'pa.user_id' => $user_id,
            'p.is_deleted' => 0,
            'p.status' => STATUS_ACTIVE
        ]);
        $this->db->join('pls_partners as p', 'p.partner_id = pa.partner_id');

        return $this->db->get('pls_partners_admins_rel as pa')->row_array();
    }


    /**
     * Creates new partner
     * @param array $data Partner data
     * @return bool Indicates partner is created successfully or not.
     */
    function save($data)
    {
        $data = $this->pls_crud_lib->updated($this->table, $data);
        $result = $this->db->update($this->table, $data, 'partner_id = '.$data['partner_id']);
        return $result;
    }


    function save_partner_loyalty_schemes_connection($partner_id, $loyalty_schemes)
    {
        $this->delete_partner_loyalty_schemes_connection($partner_id);

        $data = [];
        foreach($loyalty_schemes as $loyalty_scheme_id) {
            $item['partner_id'] = $partner_id;
            $item['loyalty_scheme_id'] = $loyalty_scheme_id;
            $item = $this->pls_crud_lib->created('pls_partners_loyalty_schemes_rel', $item, FALSE);
            $data[] =$item;
        }

        return $this->db->insert_batch('pls_partners_loyalty_schemes_rel', $data);
    }


    function delete_partner_loyalty_schemes_connection($partner_id)
    {
        $this->db->where('partner_id', $partner_id);
        return $this->db->delete('pls_partners_loyalty_schemes_rel');
    }

}
