<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Partner_Controller
{
	public function __construct()
    {
		// !!! load permission array before parent __construct
		$this->permissions = [
			'index'    => 'partner_setting_partner',
		];
        parent::__construct();
        $this->load->model('admin/Partners_model', 'partners_model');
        $this->load->model('student/Redemptions_model', 'redemptions_model');
        $this->load->model('admin/Partner_admins_model', 'partner_admins_model');
        $this->load->model('admin/Loyalty_Schemes_model', 'loyalty_schemes_model');
    }

    /**
    * Partner settings
    */
    public function index()
    {
    	$data['data'] = $this->partners_model->load($this->partner->partner_id);
        //post data
        if($post = $this->input->post('form')) {
            $fields = ['name'];
            if ($partner_data = $this->pls_validation_lib->validate('partner', $post, $fields)) {
                $partner_data['partner_id'] = $data['data']->partner_id;
                $this->pls_file_lib->save_image_to_db($post['logo'], $data['data']->partner_id, 'partner.logo');
				if (isset($post['redeem_pin'])) {
					$this->redemptions_model->save_redeem_pin($post['redeem_pin'], 'partner', $data['data']->partner_id);
				}
                if ($this->partners_model->save($partner_data)) {
					$this->pls_alert_lib->set_flash_messages('success', lang('partner_update_success'));
					$json['redirect'] = '/student/'.$this->partner->partner_id.'/settings/general';;
                }
                else {
                    $json['message'] = ajax_messages('error', lang('partner_update_failed'));
                }
            }
            else {
                $json['validation'] = validation_messages();
            }
            echo json_encode($json);
        }
        else{
			$pin = $this->redemptions_model->get_redeem_pin('partner', $this->partner->partner_id);
			$data['redeem_pin'] = $pin?$pin->redeem_pin:'';
            $this->pls_layout_lib->partner_layout('/student/settings/general/form', $data);
        }
    }
}
