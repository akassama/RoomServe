<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PLS_Controller extends CI_Controller
{
    public $user;

    public $construction = FALSE;

    //Module permission arrays
    public $permissions;

    //Module name
    public $module_name;

    //Module's main model
    public $model;

    public function __construct()
    {
        parent::__construct();

        //UNCOMMENT THIS METHOD IN CASE SITE IS UNDER CONSTRUCTION
        // $this->going_contstruction();

        //log all users requests
        $this->log_all_requests();

        //Can be used when profiling the project
        //////////// $this->output->enable_profiler(TRUE);

        //Load langugages
        $this->lang->load('error', $this->lang->get_current_lang());
        $this->lang->load('alert', $this->lang->get_current_lang());

        //Load libraries
        $this->load->library(array("Pls_auth_lib", "Pls_grid_lib", 'Pls_file_lib', 'Pls_crud_lib'));
        //Load usergroups model
        $this->load->model('UserGroups_model', 'usergroups_model');
        //Load sidebar_nav helper
        $this->load->helper('pls_navigation');

        //Load language files
        $this->lang->load('crud', $this->lang->get_current_lang());
        $this->lang->load('table', $this->lang->get_current_lang());
        $this->lang->load('form', $this->lang->get_current_lang());

        //create user object to store user's data after user logged in
        $this->user = $this->session->userdata('user');
        //check user permissions
        $class = $this->uri->segment(1);
        if ( $class == 'admin' || $class == 'student') {
            if(! $this->pls_auth_lib->is_loggedin()){
                set_previous_url(uri_string());
                redirect('/auth/login');
            }
            $this->_check_permission();
        }
    }


    private function going_contstruction()
    {
        $this->construction = TRUE;
        $allowed_ips = ['95.46.67.202', '31.148.144.66'];
        if (uri_string() != 'site/under_construction' && !in_array($this->input->ip_address(), $allowed_ips)) {
            redirect('site/under_construction');
        }
    }


    /**
    * Checks url permissions
    */
    protected function _check_permission()
    {
        $method = $this->router->fetch_method();
        if ($this->permissions && isset($this->permissions[$method])) {
            $permission_name = $this->permissions[$method];
            if ($this->pls_auth_lib->has_access($permission_name) !== TRUE) {
                return FALSE;
            }
        }
        return TRUE;
    }


        /**
    * Get list check
    */
    public function get_list()
    {
        if (!$this->input->is_ajax_request() || !isset($this->module_name)) {
            show_404();
        }
        $preset_name = $this->input->get('preset');
    	$options = $this->pls_grid_lib->db_grid_columns($this->module_name, $this->input->post(NULL, TRUE), NULL, $preset_name);
    	$json['recordsFiltered'] = $json['recordsTotal'] = $this->model->get_grid_count($options);
        $json['data'] = $this->model->get_grid_list($options);
        // log_message('error', $this->db->last_query());

		//export to csv
        $this->export_to_csv($options);

        if(!empty($options['quick_stats'])) {
            foreach($options['quick_stats'] as $key => $qs_options) {
                $json['quick_stats'][$key] = $this->model->get_grid_count($qs_options);
            }
        }

        echo json_encode($json);
    }


    /**
    * Export grid list as csv
    */
    private function export_to_csv($options)
    {
        if($this->input->post('csv')) {
            $csv_options = $this->pls_grid_lib->csv_grid_columns($this->module_name);
			unset($options['limit']);
			$csv_data = $this->model->get_grid_list($options);
			echo  $this->pls_csv_lib->generate_csv_report($csv_data, $csv_options);
            exit();
        }
    }
    

    /*
    *   Logs all requests
    */
    protected function log_all_requests()
    {
        if ($this->uri->segment(1) != 'files' || $this->uri->segment(2) != 'photos') {
            $this->load->library('user_agent');

            $msg = PHP_EOL . PHP_EOL . date('H:i:s');
            $method = $this->input->method() == 'post' ? 'POST' : 'GET';
            $msg .= ' - ' . $this->input->ip_address() . ' - ' . $method;
            $msg .= ': ' . uri_string();
            if ($this->agent->agent_string()) $msg .= PHP_EOL . '    AGENT: ' . $this->agent->agent_string();
            if ($this->input->get(NULL)) $msg .= PHP_EOL . '    GET: ' . json_encode($this->input->get(NULL));
            $post = $this->input->post(NULL);
            if (isset($post['token'])) unset($post['token']);
            if ($post) {
                if ($this->input->post('form') && isset($this->input->post('form')['password'])) {
                    unset($post['form']['password']);
                    unset($post['form']['confirm_password']);
                }
                $msg .= PHP_EOL . '    POST: ' . json_encode($post);
            }
            $log_dir = APPPATH.'logs/request-logs';
            if (! is_dir($log_dir)) {
                mkdir($log_dir);
            }
            $myFile = $log_dir.'/hgkler9034-request_log_'.date('Y-m-d').'.php';
            if (! is_file($myFile)) {
                $fh = fopen($myFile, 'a') or die("can't open file");
                fwrite($fh, "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>");
                fclose($fh);
            }
            $fh = fopen($myFile, 'a') or die("can't open file");
            fwrite($fh, $msg);
            fclose($fh);
        }
    }
}


class Admin_Controller extends PLS_Controller
{

    public function __construct()
    {
        parent::__construct();

        //check user permissions
        if(! $this->pls_auth_lib->is_admin()){
           show_403();
        }

        $this->lang->load('admin/module', $this->lang->get_current_lang());
    }
}


class Partner_Controller extends PLS_Controller
{
    //global partner object
    public $student;

    public function __construct()
    {
        parent::__construct();

        //Load models
        $this->load->model('student/Students_model', 'students_model');

        //Get student object
        $student_id = $this->uri->segment(2);
        if (is_numeric($student_id) && $this->students_model->student_matchs($student_id)) {
            $this->student = $this->students_model->load($student_id);
        }
        else {
            show_404();
        }
        //Load language files
        $this->lang->load('student/module', $this->lang->get_current_lang());

    }
}

