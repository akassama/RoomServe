<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global alert messages Library
 *
 * @author     bzimor <bobzimor@gmail.com>
 * @version    1.1
 */
class Pls_alert_lib
{
    public $global_messages;
    public $flash_messages;
    /**
     * Constructor
     */
    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();
    }

    /**
     * Set flash messages
     * Sets messages to flashdata according to its type
     * @param string $type Message type like success, info, warning or error
     * @param string $message Message to add to array
     */
    public function set_flash_messages($type='success', $message = '')
    {
        if ($message != '') {
            $this->flash_messages[] = $message;
            $this->CI->session->set_flashdata($type, $this->flash_messages);
        }
    }

    /**
     * Set messages
     * Sets messages to an array according to its type
     * @param string $type Message type like success, info, warning or error
     * @param string $message Message to add to array
     */
    public function set_global_messages($type='success', $message = '')
    {
        if ($message != '') {
            $this->global_messages[$type][] = $message;
            $this->CI->session->set_userdata('message', $this->global_messages);
        }
    }

    /**
     * Get flash messages
     * Returns flash messages according to its type
     * @return array Array of flash messages, empty array if no flashdata
     */
    public function get_flash_messages($type = '')
    {
        if ($type == '') {
            return $this->CI->session->flashdata();
        }
        else {
            return $this->CI->session->flashdata($type);
        }
    }

    /**
     * Get global messages
     * Returns global messages according to its type
     * @return array Array of messages, empty array if no message
     */
    public function get_global_messages($type = '')
    {
        if ($type == '') {
            return $this->CI->session->userdata('message');
        }
        else {
            return $this->CI->session->userdata('message')[$type];
        }
    }

    /**
     * Clear messages
     * Removes all message arrays
     */
    public function clear_messages()
    {
        $this->global_messages = [];
        $this->flash_messages = [];
        $this->CI->session->unset_userdata('message');
    }
}
