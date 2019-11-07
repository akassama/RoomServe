<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Encrypt file url string
 * @param string URL string to encrypt
 * @return string Encrypted string
 */
function encrypt_file_url($string) {
 	$encryption_conf = config_item('encryption');

	//get encryption configurations from config
    $key = $encryption_conf['key'];
    $method = $encryption_conf['method'];
    $iv = $encryption_conf['iv'];
    $output = openssl_encrypt($string, $method, $key, 0, $iv);

    return base64_encode($output);
}


/**
 * Decrypt encrypted file url string
 * @param string Encrypted string to decrypt
 * @return string Decrypted string
 */
function decrypt_file_url($encrypted_string) {
 	$encryption_conf = config_item('encryption');

	//get encryption configurations from config
    $key = $encryption_conf['key'];
    $method = $encryption_conf['method'];
    $iv = $encryption_conf['iv'];
    $output = openssl_decrypt(base64_decode($encrypted_string), $method, $key, 0, $iv);

    return $output;
}


/**
 * Encrypt file url string
 * @param string URL string to encrypt
 * @return string Encrypted string
 */
function encrypt_user_info($string) {
    if ($string) {
     	$encryption_conf = config_item('user_encryption');

    	//get encryption configurations from config
        $key = $encryption_conf['key'];
        $method = $encryption_conf['method'];
        $iv = $encryption_conf['iv'];
        $output = openssl_encrypt($string, $method, $key, 0, $iv);

        return $output;
    }
}


/**
 * Decrypt encrypted file url string
 * @param string Encrypted string to decrypt
 * @return string Decrypted string
 */
function decrypt_user_info($encrypted_string) {
    if ($encrypted_string) {
        $encryption_conf = config_item('user_encryption');

        //get encryption configurations from config
        $key = $encryption_conf['key'];
        $method = $encryption_conf['method'];
        $iv = $encryption_conf['iv'];
        $output = openssl_decrypt($encrypted_string, $method, $key, 0, $iv);

        return $output;
    }
}
