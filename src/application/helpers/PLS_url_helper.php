<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create url
 * @param string $uri
 * @param string $title
 * @param string $attributes
 * @return string
 */
if ( ! function_exists('create_url')) {

    function create_url($uri = '')
    {
        $ci =& get_instance();

        $uri = '/admin'.$uri;
        $uri = $ci->lang->get_uri($ci->lang->get_current_lang(), $uri);

        return site_url($uri);
    }
}

/**
 * Create partner url
 * @param string $uri
 * @param string $title
 * @param string $attributes
 * @return string
 */
if ( ! function_exists('create_partner_url')) {

    function create_partner_url($uri = '')
    {
    
        $ci =& get_instance();
        $uri = '/student/'.$ci->student->user_id.$uri;
        $uri = $ci->lang->get_uri($ci->lang->get_current_lang(), $uri);

        return site_url($uri);
    }
}

/**
 * Set previous url if user redirected to login
 * @param string $uri
 */
function set_previous_url($uri)
{
	$ci =& get_instance();
	$ci->session->set_tempdata('prev_url', $uri, 60);
}


/**
 * Get previous url to redirect back after user successfully logged in
 * @return string previous url or '/'
 */
function get_previous_url($admin = FALSE)
{
	$ci =& get_instance();
	if ($ci->session->tempdata('prev_url') !== NULL) {
		return '/'.$ci->session->tempdata('prev_url');
	}
	else {
        if ($admin) {
            return '/admin/dashboard';
        }
        else {
            return '/student/'.$ci->user->user_id.'/dashboard';
        }
	}

}


function show_403()
{
    $_error =& load_class('Exceptions', 'core');
    $_error->show_403();
    exit(4); // EXIT_UNKNOWN_FILE
}


function list_generator_url()
{
	$ci =& get_instance();
	$type = $ci->uri->segment(1);

	if ($type == 'admin') {
		return '/admin/tools/list_generator/';
	}
	elseif($type == 'student') {
		return '/student/'.$ci->student->user_id.'/tools/list_generator/';
	}
}
