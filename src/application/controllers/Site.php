<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends PLS_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(! $this->pls_auth_lib->is_loggedin()){
            redirect('/auth/login');
        }
        else {
            $is_admin = $this->pls_auth_lib->is_admin();
            redirect(get_previous_url($is_admin));
        }
    }


    public function under_construction()
    {
        if ($this->construction === TRUE) {
            $this->load->view('construction.php');
        }
        else {
            redirect('/');
        }
    }
}
