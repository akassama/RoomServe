<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends Admin_Controller
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
            $result['user_id'] = $user->user_id;
            $result['user'] = $user->first_name . ' ' . $user->last_name;
            $result["status"] = true;
			$result['role'] = $user->user_role;
			$result['role_name'] = lang('form_'.$user->user_role);
			if ($user->partner_id) {
				$result['partner_id'] = $user->partner_id;
			}
        }
        echo json_encode($result);
    }


    //get group list using ajax
    public function group_list()
    {
        if ($this->_check_permission('access_administrators')) {
            $data = $this->usergroups_model->get_all_groups();
            if ($data) {
                echo json_encode($data);
            }
        }
    }


    //get partner group list using ajax
    public function partner_group_list($partner_id)
    {
        if ($this->_check_permission('access_partners')) {
            $data = $this->usergroups_model->get_all_partner_groups($partner_id, TRUE);
            if ($data) {
                echo json_encode($data);
            }
        }
    }


	/**
	* Get nationality list using ajax
	*/
    public function nationality_list()
    {
        $data = file_get_contents("./assets/countries/country_en.json"); //only english!
        if ($data) {
			$data = json_decode($data, TRUE);
			$ordered = [];
			foreach ($data as $key => $value) {
				$item['key'] = $key;
				$item['val'] = $value;
				$ordered[] = $item;
			}
			echo json_encode($ordered);
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
