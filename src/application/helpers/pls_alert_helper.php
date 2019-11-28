<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function flash_messages($type = NULL)
{
    $ci =& get_instance();
    $msg_div = '';
    $flash = $ci->pls_alert_lib->get_flash_messages();
    if ($type) {
        if (isset($flash[$type]) && $flash[$type]) {
            $msg_div = $flash[$type][0];
        }
        return $msg_div;
    }
    $msg_types = array_keys($flash);

    foreach ($msg_types as $msg_type){
        if ($flash[$msg_type]){
            $msg_div .= '<div class="alert alert-'.$msg_type.' flash-msg">'."\n";
            foreach ($flash[$msg_type] as $msg_item) {
                $msg_div .="<p>$msg_item</p>\n";
            }
            $msg_div .='</div>';
        }
    }
    return $msg_div;
}


function global_messages()
{
    $ci =& get_instance();
    $msg_div = '';
    $global_msg = $ci->pls_alert_lib->get_global_messages();
    if ($global_msg) {
        $msg_types = array_keys($global_msg);

        foreach ($msg_types as $msg_type){
            if ($global_msg[$msg_type]){
                $msg_div .= '<div class="alert alert-'.$msg_type.' global-msg">'."\n";
                foreach ($global_msg[$msg_type] as $msg_item) {
                    $msg_div .="<p>$msg_item</p>\n";
                }
                $msg_div .='</div>';
            }
        }
        return $msg_div;
    }
}


function validation_messages()
{
    $msg = '<div class="alert alert-error validation-msg">';
    $errors = explode("\n", validation_errors());
    array_pop($errors);
    $ul = '<ul>';
    foreach ($errors as $error) {
        $ul .= "<li>$error</li>";
    }
    $ul .="</ul>";
    $msg .= $ul;
    $msg .= '</div>';
    return $msg;
}


function ajax_messages($type, $message, $with_html = TRUE)
{
    $msg['status'] = $type;
    if ($with_html) {
        $msg['text'] = '<div class="alert alert-'.$type.' ajax-msg">';
    }
    else {
        $msg['text'] = '';
    }
    $msg['text'] .= $message;
    $msg['text'] .= '</div>';
    return $msg;
}
