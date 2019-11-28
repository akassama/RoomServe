<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PLS_Exceptions extends CI_Exceptions
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
	 * 403 Error Handler
	 *
	 * @uses	CI_Exceptions::show_error()
	 *
	 * @param	string	$page		Page URI
	 * @param 	bool	$log_error	Whether to log the error
	 * @return	void
	 */
	public function show_403()
	{
        $CI =& get_instance();
        $data['heading'] = lang('error_403_heading');
        $data['message'] = lang('error_403_message');
        if ($CI->pls_auth_lib->is_admin()) {
            $layout = '/admin/errors/';
        }
        else {
            if (isset($CI->user->partner_id)) {
                $data['partner_id'] = $CI->user->partner_id;
            }
            $layout = '/student/errors/';
        }
        $message = $CI->pls_layout_lib->errors_layout($layout.'error-403', $data);

		// By default we log this, but allow a dev to skip it
		// if ($log_error)
		// {
		// 	log_message('error', $heading.': '.$page);
		// }

		show_error($message, 403, '');
		exit(4); // EXIT_UNKNOWN_FILE
	}


    /**
	 * 404 Error Handler
	 *
	 * @uses	CI_Exceptions::show_error()
	 *
	 * @param	string	$page		Page URI
	 * @param 	bool	$log_error	Whether to log the error
	 * @return	void
	 */
	public function show_404($page = '', $log_error = TRUE)
	{
        $CI =& get_instance();
        $data['heading'] = lang('error_404_heading');
        $data['message'] = lang('error_404_message');
        if ($CI->pls_auth_lib->is_admin()) {
            $layout = '/admin/errors/';
        }
        else {
            if (isset($CI->user->partner_id)) {
                $data['partner_id'] = $CI->user->partner_id;
            }
            $layout = '/student/errors/';
        }
        $message = $CI->pls_layout_lib->errors_layout($layout.'error-404', $data);

		// By default we log this, but allow a dev to skip it
		// if ($log_error)
		// {
		// 	log_message('error', $heading.': '.$page);
		// }

		show_error($message, 404, '');
		exit(4); // EXIT_UNKNOWN_FILE
	}


    /**
	 * General Error Page
	 *
	 * Takes an error message as input (either as a string or an array)
	 * and displays it using the specified template.
	 *
	 * @param	string		$heading	Page heading
	 * @param	string|string[]	$message	Error message
	 * @param	string		$template	Template name
	 * @param 	int		$status_code	(default: 500)
	 *
	 * @return	string	Error page output
	 */
	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		//<< bzimor
		if ($status_code == 403 || $status_code == 404) {
            set_status_header($status_code);
            echo $message;
			exit;
		}
		//bzimor >>

		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		if (is_cli())
		{
			$message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
			$template = 'cli'.DIRECTORY_SEPARATOR.$template;
		}
		else
		{
			set_status_header($status_code);
			$message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
			$template = 'html'.DIRECTORY_SEPARATOR.$template;
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}
