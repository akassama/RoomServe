<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_post_messages';
    }

    public function save_message($id, $type = TYPE_VENUE, $message, $message_type)
    {
        //delete old message
        $this->db->where(['type_id' => $id, 'type' => $type])->delete($this->table);

        //insert message
        $data['type'] = $type;
        $data['type_id'] = $id;
        $data['message'] = $message;
        $data['message_type'] = $message_type;
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function get_message($id, $type, $message_type)
    {
        $this->db->where(['type_id' => $id, 'type' => $type, 'message_type' => $message_type]);
        $message = $this->db->get($this->table)->row();
        return $message;
    }

    public function delete_message($id, $type = TYPE_VENUE, $message_type)
    {
        $this->db->where(['type_id' => $id, 'type' => $type, 'message_type' => $message_type])->delete($this->table);
    }
}
