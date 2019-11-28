<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customizable Form Validation Library
 *
 * @author     bzimor <bobzimor@gmail.com>
 * @version    1.0
 */
class Pls_validation_lib
{
    /**
     * All form fields validation helper array
     * Add newly created form validation helper here
     */
    public $helpers = array(
        'user'                   => 'user_validation',
        'group'                  => 'group_validation',
        'cleaning_options'           => 'cleaning_options_validation',
        'payment_options'            => 'payment_options_validation',
        'personal_options'            => 'personal_options_validation',

        'orders'                 => 'orders_validation',
    );

    /**
     * Array that used to store field names from loaded helper
     */
    public $fields = [];

    /**
     * Array that used to store field names from loaded helper
     */
    public $field_names = [];


    public function __construct()
    {
        // get main CI object
        $this->CI = &get_instance();
        $this->CI->load->library('form_validation');
    }

    /**
    * Main function to check form validation according to criteria
    * @param string $name Validated object name, e.g. 'user'
    * @param array $data Data which is validated
    * @param array || string || NULL $required_fields Field(s) which needs validating
    * @return bool Indicates validation success or failed
    */
    public function validate($name, $data, $required_fields = NULL, $additional_check = [])
    {
        if (in_array($name, array_keys($this->helpers))) {
            $this->fields = $this->load_helper($name);
            if ($this->fields) {
                if ($additional_check) {
                    foreach ($additional_check as $key => $checks) {
                        foreach ($checks as $check) {
                            $this->fields[$key]['rules'][] = $this->fields[$key]['additional_rules'][$check];
                        }
                    }
                }
                $rules = $this->get_rules($required_fields);
                $filtered_data = $this->filter_data($data);
                //setting filtered data to validate
                $this->CI->form_validation->set_data($filtered_data);
                //setting rules
                $this->CI->form_validation->set_rules($rules);
                //Change Error delimiters
                $this->CI->form_validation->set_error_delimiters('', '');
                if ($this->CI->form_validation->run() === TRUE) {
                    return $filtered_data;
                }
            }
        }
        return FALSE;
    }

    /**
    * Loads specific validation helper, stores form field names and return rules array
    * @param string $name
    */
    private function load_helper($name)
    {
        $this->CI->load->helper('validation/' . $this->helpers[$name]);
        $myfunc = $name.'_rules';
        try{
            $fields = $myfunc();
        }
        catch(Exception $e){
            return FALSE;
        }
        $this->field_names = array_keys($fields);
        return $fields;
    }

    /**
    * Filters data values according to Validation field
    * @param array $data
    */
    private function filter_data($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        $filtered_data = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $this->field_names)) {
                $filtered_data[$key] = trim($value);
            }
        }
        return $filtered_data;
    }

    /**
    * Returns field rules according to criteria
    * @param array || string || NULL $required_fields
    */
    private function get_rules($required_fields)
    {
        $rules = [];
        if (!$required_fields) {
            foreach ($this->fields as $key => $field) {
                $rules[] = $field;
            }
        }
        else {
            if (is_array($required_fields)) {
                foreach ($required_fields as $value) {
                    if (in_array($value, $this->field_names)) {
                        $rules[] = $this->fields[$value];
                    }
                }
            }
            else {
                if (in_array($required_fields, $this->field_names)) {
                    $rules[] = $this->fields[$required_fields];
                }
            }
        }
        return $rules;
    }
}
