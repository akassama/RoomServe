<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function group_rules(){
    $fields =  [
        'name' => [
            'field' => 'name',
            'label' => lang('form_name'),
            'rules' => ['required', 'min_length[3]', 'max_length[255]']
        ],
        'status' => [
            'field' => 'status',
            'label' => lang('form_status'),
            'rules' => ['trim', 'required', 'integer']
        ]
    ];
    return $fields;
}
