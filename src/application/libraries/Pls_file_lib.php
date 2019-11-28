<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * File and image manipulation Library
 *
 * @author     bzimor <bobzimor@gmail.com>
 * @version    1.2
 */

class Pls_file_lib
{

    public $CI;

    //image related config settings
    public $file_conf;

    //uploaded image data
    public $file_data;

    //image manipulation errors
    public $errors = '';


    public function __construct()
    {
        $this->CI = &get_instance();
        //Set all image configurations
        $this->file_conf = $this->CI->config->item('image');
    }

    /*==========================================================================
    |                            IMAGE OPERATIONS
    |==========================================================================*/

    /**
     * Upload image to temp folder
     * @param string $file uploaded  file from form upload
     * @param string $file_type image type to determine its configurations
     * @param int $id ID to use naming image and to save db later
     * @param bool $thumb If true, after upload, created image thumb
     * @return array Returns array with encrypted name, temp thumb file url
     */
    public function temp_file_upload($file, $file_type, $id = 0)
    {
    	$data['status'] = FALSE;
    	if (! $id) return FALSE;
        //get config array
        $file_conf = $this->get_config($file_type);
        //Check temp image folder, create if not exists
    	$options['upload_path'] = $this->make_dir($this->config_item($file_conf, 'temp_path'));
        //Set specific image configuration
        $options['allowed_types'] = $this->config_item($file_conf, 'allowed_types');
        //max uploaded file size is 10mb
        $options['max_size'] = 10240;
        //For file naming we use base64 encoding
        $options['file_name'] = base64_encode($file_conf['naming'].$id.'__'.date('ymdHis'));
        if ($this->file_upload($file, $options)) {
    		$data['status'] = TRUE;
            $data['name'] = encrypt_file_url($this->file_data['file_name']);
        	if ($file_conf['is_image']) {
                if (isset($file_conf['size']['s'])) {
                    $size = $file_conf['size']['s'];
                }
                else {
                    $size = $this->file_conf['size']['s'];
                }
                $data['thumb'] = $this->create_preview($size);
                $data['original'] = $this->create_preview($size, TRUE);
        	}
            else {
                $data['thumb'] = '';
                $data['original'] = $file_conf['temp_preview']['url'] . encrypt_file_url($this->file_data['full_path']);
                $file_size = filesize($this->file_data['full_path']);
                $file_size = ($file_size > 1048576)? number_format($file_size / 1048576, 2) . ' MB':number_format($file_size / 1024, 2) . ' KB';
                $data['details'] = [
                    'file_size' => $file_size,
                    'file_extension' => ltrim($this->file_data['file_ext'], '.'),
                    'uploaded_time' => date('d M Y H:i:s'),
                    'uploaded_by' => trim($this->CI->user->first_name . ' ' . $this->CI->user->last_name),
                ];
            }
    	}
        $data['message'] = $this->errors;
    	return $data;
    }


    /**
     * Gets resized image path from path or creates new one if not exists
     * @param string $encrypted_name Encrypted image name
     * @param string $image_type image type to determine its configurations
     * @param string $size_type Image size type, e.g. 'original' or 's'
     * @param string $dim pecifies what to use as the master axis when resizing image, e.g. auto or width
     * @return string Returns Related image path
     */
    public function get_image($encrypted_name, $image_type, $size_type, $dim = 'auto')
    {
        //decrypt image name
        if (! $image_name = decrypt_file_url($encrypted_name)) return FALSE;
        //get specific image type config, e.g. avatar.admin
        $file_conf = $this->get_config($image_type);
        $folder = $this->file_conf['folder'][$size_type];
        if ($image_path = $this->image_exists($file_conf['path'], $folder, $image_name)) {
            return $image_path;
        }
        if (isset($file_conf['size'][$size_type])) {
            $size = $file_conf['size'][$size_type];
        }
        else {
            $size = $this->file_conf['size'][$size_type];
        }
        $original_folder = $this->file_conf['folder']['original'];
        $image_path = $this->image_exists($file_conf['path'], $original_folder, $image_name);
        $new_path = $this->make_dir($file_conf['path'].$folder);
        return $this->image_resize($image_path, $size, $new_path, '', $dim);
    }


    /**
     * Gets attached file path from path
     * @param string $encrypted_name Encrypted file name
     * @param string $attachment_type file type to determine its configurations
     * @return string Returns Related file path
     */
    public function get_attachment($encrypted_name, $attachment_type)
    {
        //decrypt file name
        if (! $file_name = decrypt_file_url($encrypted_name)) return FALSE;
        //get specific image type config, e.g. avatar.admin
        $file_conf = $this->get_config($attachment_type);
        $file = '.' . $file_conf['path'] . $file_name;
        if (file_exists($file)) {
            return $file;
        }
    }


    /**
     * Saves image to specific field in database table
     * @param string $encrypted_name Encrypted image name
     * @param int $id Row ID to save image on specific row
     * @param string $image_type image type to determine its configurations
     * @return bool Returns TRUE if success, otherwise FALSE
     */
    public function save_image_to_db($encrypted_name, $id, $image_type)
    {
        if ($encrypted_name) {
            $image_name = decrypt_file_url($encrypted_name);
            $image_path = '.'.$this->file_conf['temp_path'].$image_name;
            if(file_exists($image_path)) {
                $file_conf = $this->get_config($image_type);
                $dir = $file_conf['path'].$this->file_conf['folder']['original'];
                $path = $this->make_dir($dir);
                //make image name
                $new_path = $this->make_file_name($image_path, $path);
                if (! rename($image_path, $new_path)) {
                    log_message('error', 'Image save error: Unable to move image to '.$new_path);
                    return FALSE;
                }
                return $this->update_db($file_conf, $image_name, $id);
            }
        }
        return FALSE;
    }


    /**
     * Saves image to specific field in database table
     * @param string $encrypted_name Encrypted image name
     * @param int $id Row ID to save image on specific row
     * @param string $image_type image type to determine its configurations
     * @return bool Returns TRUE if success, otherwise FALSE
     */
    public function save_file_to_db($encrypted_name, $id, $file_type)
    {
        if ($encrypted_name) {
            $file_name = decrypt_file_url($encrypted_name);
            //get config array
            $file_conf = $this->get_config($file_type);
            $file_path = '.'.$this->config_item($file_conf, 'temp_path').$file_name;
            if(file_exists($file_path)) {
                $dir = $file_conf['path'];
                $path = $this->make_dir($dir);
                //make image name
                $new_path = $this->make_file_name($file_path, $path);
                if (! rename($file_path, $new_path)) {
                    log_message('error', 'File save error: Unable to move file to '.$new_path);
                    return FALSE;
                }
                return $this->update_db($file_conf, $file_name, $id);
            }
        }
        return FALSE;
    }


    /**
     * Saves files to specific field in database table
     * @param string $encrypted_name Encrypted file name
     * @param int $id Row ID to save image on specific row
     * @param string $image_type image type to determine its configurations
     * @return bool Returns TRUE if success, otherwise FALSE
     */
    public function save_files_to_db($encrypted_name, $id, $file_type)
    {
        if (is_array($encrypted_name)) {
            foreach ($encrypted_name as $key => $value) {
                $this->save_file_to_db($value, $id, $file_type);
            }
        }
    }


    /**
     * Saves images to specific field in database table
     * @param array $image_array Encrypted image name
     * @param int $id Row ID to save image on specific row
     * @param string $image_type image type to determine its configurations
     */
    public function save_images_to_db($image_array, $id, $image_type)
    {
        foreach ($image_array as $image_name) {
            $this->save_image_to_db($image_name, $id, $image_type);
        }
    }


    /**
    * Remove image from all size folders and database
    * @param string $encrypted_name Encrypted image name
    * @param string $image_type image type to determine its configurations
    * @param int $id ID to use naming image and to save db later
    * @return bool Returns TRUE if success, otherwise FALSE
    */
    public function remove_uploaded_image($encrypted_name, $image_type, $id, $soft_delete = FALSE)
    {
        if (! $image_name = decrypt_file_url($encrypted_name)) return FALSE;
        //get specific image type config, e.g. avatar
        $file_conf = $this->get_config($image_type);
        $path = $file_conf['path'];
        foreach ($this->file_conf['folder'] as $folder) {
            $img = $this->image_exists($path, $folder, $image_name);
            if ($img && !$soft_delete) {
                unlink($img);
            }
        }
        return $this->update_db($file_conf, $image_name, $id, TRUE, $soft_delete);
    }


    /**
    * Remove attachment from all size folders and database
    * @param string $encrypted_name Encrypted attachment name
    * @param string $attachment_type attachment type to determine its configurations
    * @param int $id ID to use naming attachment and to save db later
    * @return bool Returns TRUE if success, otherwise FALSE
    */
    public function remove_uploaded_attachment($encrypted_name, $attachment_type, $id)
    {
        if (! $attachment_name = decrypt_file_url($encrypted_name)) return FALSE;
        //get specific attachment type config, e.g. avatar
        $file_conf = $this->get_config($attachment_type);
        $file = '.' . $file_conf['path'] . $attachment_name;
        if (file_exists($file)) {
            unlink($file);
        }
        return $this->update_db($file_conf, $attachment_name, $id, TRUE);
    }


    /**
     * Update db table field with value
     * @param array Specific configuration array
     * @param string $value Real image file name
     * @param int $id Row ID to save image on specific row
     * @param bool $remove Removes row if TRUE
     * @return bool Returns TRUE if success, otherwise FALSE
     */
     private function update_db($conf, $value, $id, $remove = FALSE, $soft_delete = FALSE)
    {
        if ($conf['separate_table']) {
            if ($remove) {
                if ($soft_delete) {
                    //only for order photos
                    return $this->CI->db->update($conf['db_table'], ['is_deleted' => 1], $conf['db_field'] . ' = "' . $value .'" and type = "order" and type_id = "' . $id . '"');
                }
                $this->CI->db->where($conf['db_field'], $value);
                return $this->CI->db->delete($conf['db_table']);
            }
            $data['created_by'] = $this->CI->user->user_id;
            $data[$conf['db_field']] = $value;
            $data[$conf['db_id']] = $id;
            if (isset($conf['type'])) {
                $data['type'] = $conf['type'];
            }
            if (isset($conf['attachment_type'])) {
                $data['attachment_type'] = $conf['attachment_type'];
            }
            return $this->CI->db->insert($conf['db_table'], $data);
        }
        else {
            $data[$conf['db_field']] = $value;
            if ($remove) {
                $data[$conf['db_field']] = '';
            }
            return $this->CI->db->update($conf['db_table'], $data, $conf['db_id'].'='.$id);
        }
    }


    /**
     * Get image configurations based on image type
     * @param string $image_type image type to determine its configurations
     * @param int $depth Array index depth to get specific configurations
     * @return array Returns Specific configuration array
     */
    private function get_config($image_type, $depth = 0)
    {
        $type = explode('.', $image_type);
        $loops = (count($type) < $depth || $depth == 0)?count($type):$depth;
        if (count($type) > 1) {
            if (! isset($this->file_conf[$type[0]])) return FALSE;
            $conf = $this->file_conf[$type[0]];
            if ($loops > 1) {
                for ($i=1; $i < $loops; $i++) {
                    if (! isset($conf[$type[$i]])) return FALSE;
                    $conf = $conf[$type[$i]];
                }
            }
        }
        else {
            $conf = $this->file_conf[$image_type];
        }
        return $conf;
    }

    /**
     * Get local file configuration or global
     * @param array Specific configuration array
     * @param string $key configuration key
     * @return value Returns Specific configuration value
    */
    private function config_item($config_array, $key)
    {
        if (isset($config_array[$key])) {
            return $config_array[$key];
        }
        else {
            return $this->file_conf[$key];
        }
    }


    /**
     * Create thumb image for preview
     * @param array $size thumb size array, e.g. [48, 48]
     * @param bool $original if TRUE, returns original image instead of thumb
     * @return mixed Returns encrypted thumb path or FALSE on failure
     */
    private function create_preview($size, $original = FALSE)
    {
        //setting size for resizing
        $image_full_path = '.'.$this->file_conf['temp_path'].$this->file_data['file_name'];
        if (! $original) {
            if ($resized_image = $this->image_resize($image_full_path, $size, '', TRUE)) {
                return $this->file_conf['temp_preview']['url'].encrypt_file_url($resized_image);
            }
            else {
                log_message('error', 'Image creation error: Unable to create preview');
                return FALSE;
            }
        }
        else {
            return $this->file_conf['temp_preview']['url'].encrypt_file_url($image_full_path);
        }
    }


    /**
     * Upload image to server
     * @param file $file form uploaded image file
     * @param array $options upload options for library
     * @return bool Returns TRUE on success or FALSE on failure
     */
    private function file_upload($file, $options)
    {
        //Load upload library
        $this->CI->load->library("upload");
    	//Initialize upload library with options
        $this->CI->upload->initialize($options);
        if($this->CI->upload->do_upload($file)) {
            $this->file_data = $this->CI->upload->data();
            return TRUE;
        }
        $this->errors = $this->CI->upload->display_errors();
        return FALSE;
    }


    /**
     * Image resize
     * @param string $path real file path to resize
     * @param array $size image size to be resized, [100, 100]
     * @param bool $thumb_marker Add thumb_marker or not
     * @return bool Returns TRUE on success or FALSE on failure
     */
    private function image_resize($image_path, $size, $new_path = '', $thumb_marker = '', $dim = 'auto')
	{
	    $config['image_library'] = 'imagemagick';
        $config['library_path'] = '/usr/bin/convert';
        $config['maintain_ratio'] = TRUE;
	    $config['width'] = $size[0];
	    $config['height'] = $size[1];
	    $config['master_dim'] =$dim; //'auto, width' or 'height'
        $config['thumb_marker'] = '';
        if ($thumb_marker) {
            $config['create_thumb'] = TRUE;
            $thumb_marker = '_'.$size[0].'x'.$size[1];
            $config['thumb_marker'] = $thumb_marker;
        }
        if ($new_path) {
            $config['new_image'] = $new_path;
        }
	    if(file_exists($image_path)) {
            $config['source_image'] = $image_path;
            $this->CI->load->library('image_lib');
            $this->CI->image_lib->initialize($config);
            if($this->CI->image_lib->resize()) {
                return $this->make_file_name($image_path, $new_path, FALSE, $thumb_marker);
            }
            $this->errors = $this->CI->image_lib->display_errors();
        }
        return FALSE;
	}


    /**
     * Checks if image file exists or not
     * @param string $path Related folder path
     * @param string $folder Specific image folder
     * @param string $name Image file name
     * @return bool Returns TRUE if file exists, otherwise FALSE
     */
	private function image_exists($path, $folder, $name)
	{
		$filepath = '.'.$path.$folder.'/'.$name;
        if (file_exists($filepath)) {
            return $filepath;
        }
        return FALSE;
	}


    /**
     * Create new folder if not exists and return path
     * @param string $path Related folder path
     * @return string Returns related folder path
     */
	private function make_dir($path, $slash = TRUE)
	{
        $path = rtrim($path, '/');
        $dirs = explode('/', $path);
        $dir_path = '.';
        for ($i=1; $i < count($dirs); $i++) {
            $dir_path = $dir_path.'/'.$dirs[$i];
            if (! is_dir($dir_path)) {
                mkdir($dir_path);
            }
        }
        if ($slash) {
            $path = $path.'/';
        }
        return '.'.$path;
	}


	/*==========================================================================
    |                         GENERAL FILE OPERATIONS
    |==========================================================================*/

	/**
     * Make file name
     * @param string $old_fullpath Related source file path e.g. ./uploads/temp/photo.jpg
     * @param string $new_path Related file path ./uploads/users/
     * @param string $new_name New file name my_photo.jpg
     * @param string $suffix File name suffix before extension my_photo_20x20.jpg
     * @return string Returns new full file path
     */
    private function make_file_name($old_fullname, $new_path = '', $new_name = '', $suffix = '')
    {
        $file = pathinfo($old_fullname);
        $path = $file['dirname'].'/';
        $filename = $file['filename'];
        if ($new_path) {
            $path = $new_path;
        }
        if ($new_name) {
        	$filename = $new_name;
        }
        return $path.$filename.$suffix.'.'.$file['extension'];
    }
}
