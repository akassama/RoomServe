<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Photos_model extends PLS_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'pls_post_photos';
    }


    public function get_post_photos($post_id, $type)
    {
        $options['fields'] = 'type, type_id, photo_id, photo';
        $options['where']['type'] = $type;
        $options['where']['is_deleted'] = 0;
        $options['where']['type_id'] = $post_id;

        $photos = $this->get_list($options);

        $grouped = [];
        if ($photos) {
            foreach ($photos as $photo) {
                $grouped[] = [ //array index must be empty
                    'photo_id'       => $photo->photo_id,
                    'photo'          => encrypt_file_url($photo->photo),
                ];

            }
        }
        return $grouped;
    }


    public function get_order_photos($order_id)
    {
        $options['as_array'] = TRUE;
        $options['fields'] = 'photo';
        $options['where']['type'] = 'order';
        $options['where']['type_id'] = $order_id;
        $photos = $this->get_list($options);
        $grouped = [];
        if ($photos) {
            foreach ($photos as $key => $photo) {
                $grouped[] = encrypt_file_url($photo['photo']);
            }
        }
        return $grouped;
    }
}
