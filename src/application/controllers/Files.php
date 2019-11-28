<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends PLS_Controller
{

	public function __construct()
    {
        parent::__construct();

		//Set all image configurations
		$this->file_types = $this->config->item('file_types');
    }


	/**
	* Image files link
	*/
    public function photos($module, $image_type, $size_type, $fileurl='')
    {
		if ($fileurl && $this->_file_permissions('photos', $module, $image_type, $fileurl)) {
			$type = $module.'.'.$image_type;
			if($file = $this->pls_file_lib->get_image($fileurl, $type, $size_type)) {
				$fp = fopen($file, 'rb');
				$f_ext = strtolower(pathinfo($file)['extension']);
				header("Content-Type: ".$this->file_types[$f_ext]);
				header("Content-Length: " . filesize($file));
				fpassthru($fp);
				exit;
			}
		}
    }


	/**
	* Attachment files link
	*/
	public function attachments($module, $file_type, $fileurl='')
	{
		if ($fileurl && $this->_file_permissions('attachments', $module, $file_type, $fileurl)) {
			$type = $module.'.'.$file_type;
			if($file = $this->pls_file_lib->get_attachment($fileurl, $type)) {
				$fp = fopen($file, 'rb');
				$f_ext = strtolower(pathinfo($file)['extension']);
				header("Content-Type: ".$this->file_types[$f_ext]);
				header("Content-Length: " . filesize($file));
				fpassthru($fp);
				exit;
			}
		}
	}


	/**
	* Temporary files link
	*/
	public function temp($file_type, $fileurl='')
    {
		//photo
		if ($file_type == 'photo' || $file_type == 'file') {
			$file = decrypt_file_url($fileurl);
			$fp = fopen($file, 'rb');
			$f_ext = pathinfo($file)['extension'];
			header("Content-Type: ".$this->file_types[$f_ext]);
			header("Content-Length: " . filesize($file));
			fpassthru($fp);
			exit;
		}
    }


	/**
	* Upload files
	*/
	public function upload()
	{
		if ($this->pls_auth_lib->is_loggedin() && $this->input->is_ajax_request()) {
			$file_type = $this->input->post('type');
			$id = $this->input->post('id');
			log_activity($id);
			$data = $this->pls_file_lib->temp_file_upload('file', $file_type, $id);
			echo json_encode($data);
		}
		else {
			show_404();
		}
	}

	/**
	* Remove images
	*/
	public function remove()
	{
		if ($this->input->is_ajax_request()) {
			$type = $this->input->post('type');
			$types = explode('.', $type);
			$module = $types[0];
			$file_type = $types[1];
			$id = $this->input->post('id');
			$file = $this->input->post('file');
			if ($this->_file_permissions('remove', $module, $file_type, $file)) {
				$conf = $this->config->item('image');
				if (isset($conf[$module][$file_type]['is_image']) && !$conf[$module][$file_type]['is_image']) {
					$data = $this->pls_file_lib->remove_uploaded_attachment($file, $type, $id);
				}
				else {
					$soft_delete = FALSE;
					if (isset($this->session->userdata('user')->partner_id) && $module == 'orders') {
						$soft_delete = TRUE;
					}
					$data = $this->pls_file_lib->remove_uploaded_image($file, $type, $id, $soft_delete);
				}
				log_activity($id);
				echo json_encode($data);
			}
		}
		else {
			show_404();
		}
	}


	/**
	 * Download csv files
	 */
	public function download_reports($module, $file)
	{
		if (has_permission("export_$module")) {
			$this->pls_csv_lib->download_csv($file);
		}
	}

	/**
	 * Remove resized image files
	 */
	public function remove_resized_images()
	{
		if($this->pls_auth_lib->is_admin()){
			$file_conf = $this->config->item('image');
			foreach ($file_conf['types'] as $type) {
				foreach (glob('uploads/' . $type . '/*' ) as $dir) {
					foreach ($file_conf['folder'] as $folder) {
						if ($folder != 'original') {
							if (is_dir($dir . '/' . $folder)) {
								foreach (glob($dir . '/' . $folder . '/*') as $file) {
									if (is_file($file)) {
										unlink($file);
									}
								}
								rmdir($dir . '/' . $folder);
							}
						}
					}
				}
	        }
		}
	}


	/**
	* Check file permissions from url
	*/
	private function _file_permissions($action, $module, $file_type, $fileurl)
	{

		$permission = file_permission($module, $action, $file_type);
		if ($permission) {
			if ($file_type == 'avatar' && isset($this->user)) {
				if ($fileurl == $this->user->photo) {
					return TRUE;
				}
			}
			return has_permission($permission);
		}
		return TRUE;
	}
}
