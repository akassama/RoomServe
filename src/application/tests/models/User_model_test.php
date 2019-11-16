<?php

class User_model_test extends TestCase
{

    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Users_model');
        $this->obj = $this->CI->Users_model;
    }

    // data for creating new user
    public function create_user(){
        $data = [
            'email' => 'test@test'. date("Ymd") .'.com',
            'password' => 'testtest',
            'user_role_id' => 2,
            'language' => 'en',
            'status' => 1,
        ];
        return $data;

    }

    public function test_load()
    {
        $data = $this->create_user();
        $userId = $this->obj->save($data, true);
        $user = $this->obj->load($userId);
        $actualUserEmail = $user->email;
        $expectedUserEmail = $data['email'];
        $this->assertEquals($expectedUserEmail, $actualUserEmail);

    }

    public function test_save()
    {
        $data = $this->create_user();
        $actual = $this->obj->save($data);
        $expected = true;
        $this->assertEquals($expected, $actual);
    }
}