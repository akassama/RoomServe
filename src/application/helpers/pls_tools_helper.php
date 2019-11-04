<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Partner info extractor
 * @param string Partner configuration key e.g. name
 * @return string Partner configuration value e.g. My Partner
 */
if ( ! function_exists('project')) {

    function project($key)
    {
        $ci =& get_instance();
        $project_conf = $ci->config->item('project');
        if (isset($project_conf[$key])) {
            return $project_conf[$key];
        }
    }
}


function log_activity($module_id = NULL, $action = NULL, $new_data = FALSE )
{
    
}
