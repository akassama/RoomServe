<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pls_email_lib
{
    protected $opening_tag = '{{';
    protected $closing_tag = '}}';
    protected $company;

    /**
     * Constructor
     */
    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();

        //load Email model
        $this->CI->load->model('Email_model', 'email_model');

    }

    /**
     * Send email
     * @param array $emails
     * @param string $template
     * @param string $subject
     * @param array $data
     * @param array $attachments
     * @return bool if sent email
     */
    public function send_email($emails, $template, $data = [], $sender = [], $attachments = [])
    {
        $email_conf = $this->CI->config->item('email');
        $emails = is_array($emails) ? $emails : [$emails];
        $language_code = "en"; //TODO get user's language!!!
        $message_data = $this->_get_parsed_template($template, $language_code, $data);
        if(!$message_data)
            return FALSE;
        //sender email and name
        if (! $sender) {
            $sender['email'] = project('default_sender_email');
            $sender['name'] = lang('project_title');
        }
        $this->CI->load->library('email');
        $this->CI->email->clear();
        $this->CI->email->to($emails);
        $this->CI->email->from($sender['email'], $sender['name']);
        $this->CI->email->subject($message_data['subject']);
        $this->CI->email->message($message_data['message']);
        $this->_attachments($attachments);
        $status = $this->CI->email->send();
        $template_id = $this->CI->email_model->get_template($template, $language_code)->template_id;
        $email_data = [
            'from_'         => $sender['email'],
            'status'        => $status,
            'subject'       => $message_data['subject'],
            'body'          => $message_data['message'],
            'template_id'   => $template_id,
        ];
        $this->CI->email_model->save_email($emails, $email_data);

        return $status;
    }

    /**
     * Email attachments
     * @param array $attachments
     * @return bool true if exists attachments and attached
     */
    protected function _attachments($attachments)
    {
        if (!empty($attachments) && is_array($attachments)) {
            foreach ($attachments as $key => $item) {
                $this->CI->email->attach($item);
            }
            return true;
        }
        return false;
    }


    /**
     * Returns the Parsed Email Template.
     * @param $template_name
     * @param $language_code
     * @param $vars
     * @return string HTML with any matching variables {{varName}} replaced with there values.
     */
    public function _get_parsed_template($template_name, $language_code, $vars = [])
    {
        if(!is_array($vars))
            return FALSE;

        $template = $this->CI->email_model->get_template($template_name, $language_code);
        if(!$template)
            return FALSE;

        $html = '';
        $tagged = [];
        foreach ($vars as $key => $value) {
            $tagged[] = $this->opening_tag . $key . $this->closing_tag;
        }
        $html = str_replace(array_values($tagged), array_values($vars), $template->body);

        $message_data['subject'] = $template->subject;
        $message_data['message'] = $html;
        return $message_data;
    }
}
