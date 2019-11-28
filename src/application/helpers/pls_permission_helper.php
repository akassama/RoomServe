<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function has_permission($permission_name)
{
    return TRUE;
}


/**
* Returns permission name based on module and file type
*/
function file_permission($module, $action, $file_type)
{
     return TRUE;
}
