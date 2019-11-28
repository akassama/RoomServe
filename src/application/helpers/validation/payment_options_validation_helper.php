<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function payment_options_rules(){
    $fields =  [
        'status' => [
            'field' => 'status',
            'label' => lang('form_status'),
            'rules' => ['trim', 'required', 'integer']
        ],
        'name' => [
            'field' => 'name',
            'label' => lang('form_name'),
            'rules' => ['trim', 'required', 'min_length[3]', 'max_length[255]']
        ],
        'description' => [
            'field' => 'description',
            'label' => lang('form_description'),
            'rules' => ['trim']
        ],
    ];
    return $fields;
}
