<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function orders_rules(){
    $fields =  [
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
        'search_keywords' => [
            'field' => 'search_keywords',
            'label' => lang('form_search_keywords'),
            'rules' => ['trim', 'min_length[3]', 'max_length[255]']
        ],
        'personnel_id' => [
            'field' => 'personnel_id',
            'label' => 'Personnel',
            'rules' => ['trim', 'integer']
        ],
        'option_id' => [
            'field' => 'option_id',
            'label' => lang('form_category'),
            'rules' => ['trim', 'required', 'integer']
        ],
        'order_date' => [
            'field' => 'order_date',
            'label' => 'Order date',
            'rules' => ['trim', 'required']
        ],
        'payment_type' => [
            'field' => 'payment_type',
            'label' => 'Payment type',
            'rules' => ['trim', 'required']
        ],
    ];
    return $fields;
}
