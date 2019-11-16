<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function user_rules(){
    $ci =&get_instance();
    $fields =  [
        'email' => [
            'field' => 'email',
            'label' => lang('form_email'),
            'rules' => ['trim', 'required', 'valid_email'],
            'additional_rules' => [
                'is_unique' => ['is_unique', [$ci->users_model, 'check_email_uniqueness']],
                'allowed_email' => ['allowed_email', [$ci->users_model, 'check_allowed_emails']]
            ],
        ],
        'first_name' => [
            'field' => 'first_name',
            'label' => lang('form_first_name'),
            'rules' => ['required', 'min_length[2]', 'max_length[255]']
        ],
        'last_name' => [
            'field' => 'last_name',
            'label' => lang('form_last_name'),
            'rules' => ['required', 'min_length[2]', 'max_length[255]']
        ],
        'date_of_birth' => [
            'field' => 'date_of_birth',
            'label' => lang('form_date_of_birth'),
            'rules' => ['required']
        ],
        'gender' => [
            'field' => 'gender',
            'label' => lang('form_gender'),
            'rules' => ['required']
        ],
        'phone' => [
            'field' => 'phone',
            'label' => lang('form_phone'),
            'rules' => ['max_length[30]']
        ],
        'password' => [
            'field' => 'password',
            'label' => lang('form_password'),
            'rules' => ['trim', 'required'],
            'additional_rules' => [
                // 'is_valid_password_length' => 'callback__password_validate_length',
            ],
        ],
        'confirm_password' => [
            'field' => 'confirm_password',
            'label' => lang('form_confirm_password'),
            'rules' => ['trim', 'required', 'matches[password]']
        ],
        'status' => [
            'field' => 'status',
            'label' => lang('form_status'),
            'rules' => ['trim', 'required', 'integer']
        ],
        'title' => [
            'field' => 'title',
            'label' => lang('form_contact_title'),
            'rules' => ['required', 'min_length[2]', 'max_length[255]']
        ],
    ];
    return $fields;
}
