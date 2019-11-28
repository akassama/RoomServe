<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Partner_Controller
{

	public function __construct()
    {
        parent::__construct();
		if (!$this->input->is_ajax_request()) {
			show_404();
		}
    }

    public function list_generator($list)
    {
        $list = $this->pls_grid_lib->ajax_grid_columns($list);
        echo json_encode($list);
    }

    /**
     * Check email
     * POST @param email Email
     * @return string User data
     */
    public function check_email()
    {
        $result = [];
        $result["status"] = false;
        $email = $this->input->post('email');
		$user = $this->users_model->get_user_by(['email' => $email], TRUE);
        if($user) {
			$result["status"] = true;
            $result['message'] = lang('auth_email_not_available');

        }
        echo json_encode($result);
    }


    //get group list using ajax
    public function group_list()
    {
        if ($this->_check_permission('access_administrators_partner')) {
            $data = $this->usergroups_model->get_all_partner_groups($this->partner->partner_id);
            if ($data) {
                echo json_encode($data);
            }
        }
    }


    //get nationality list using ajax
    public function nationality_list()
    {
        $data = $this->users_model->get_nationalities();
        if ($data) {
            echo json_encode($data);
        }
    }


    //get list state to save database
    public function get_list_state()
    {
       
    }


	/**
	* Get all language array
	*/
	public function get_all_langs()
	{
		echo json_encode($this->lang->language);
	}


	/**
	* Get all currencies
	*/
	public function get_currencies()
	{
		$grouped = [];
		foreach (project('currencies') as $currency) {
			$cur = [];
			$cur['key'] = $currency;
			$cur['val'] = $currency;
			$grouped[] = $cur;
		}
		echo json_encode($grouped);
	}

}
