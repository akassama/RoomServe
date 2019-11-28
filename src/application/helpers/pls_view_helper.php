<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('active_link')) {

    function active_link($url)
    {
        $CI = &get_instance();

        $urls = explode('/', $url);
        $i = 1;
        foreach ($urls as $m) {
            if ($CI->uri->segment($i) != $m)
                return '';
            $i++;
        }

        return 'active';
    }
}

if (!function_exists('current_page')) {

    function current_page($segment = 2)
    {
        $CI = &get_instance();
        return $CI->uri->segment($segment);
    }
}

if (!function_exists('current_menu')) {

    function current_menu($page, $segment = 2)
    {
        $CI = &get_instance();
        if ($CI->uri->segment($segment) == $page) {
            return 'class="active"';
        }
        return false;
    }
}

if (!function_exists('date_format')) {

    function date_format($date, $date_format = 'd F Y')
    {
        if (!$date instanceof DateTime) {
            $date = new DateTime($date);
        }

        return $date->format($date_format);
    }
}