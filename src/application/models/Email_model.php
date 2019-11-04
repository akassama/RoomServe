<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_sent_emails';
    }

    /**
     * Get template
     * @param $template_name
     * @param $language_code
     * @param object return template data
     */
    public  function get_template($template_name, $language_code)
    {
        $this->db->where('pls_email_templates.template_name', $template_name);
        $this->db->where('pls_email_templates_translations.language', $language_code);
        $this->db->join('pls_email_templates_translations', 'pls_email_templates_translations.template_id = pls_email_templates.template_id');
        return $this->db->get('pls_email_templates')->row_object();
    }

    /**
     * Save sent email messages to database
     */
    public function save_email($emails, $email_data)
    {
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $email_data['to_'] = $email;
                $this->db->where(['email' => $email, 'is_deleted' => 0, 'status <>' => STATUS_DRAFT]);
                $user = $this->db->get('pls_users')->row();
                if ($user) {
                    $email_data['user_id'] = $user->user_id;
                }
                $this->db->insert($this->table, $email_data);
            }
        }
        else {
            $email_data['to_'] = $emails;
            $this->db->insert($this->table, $email_data);
        }
    }
}
