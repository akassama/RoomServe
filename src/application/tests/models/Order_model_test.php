<?php

class Order_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('student/Orders_model');
        $this->CI->load->model('Users_model');
        $this->obj = $this->CI->Orders_model;
        $this->obj2 = $this->CI->Users_model;

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

    // data for creating new order
    public function create_order(){
        $userId = $this->obj2->save($this->create_user(), true);
        $data = [
            'option_id' => '0',
            'student_id' => $userId,
            'payment_type' => 'card',
            'status' => -2,
            'reason_id' => 0,
            'created_by' => $userId
        ];
        return $data;

    }

    public function test_load()
    {
        $data = $this->create_order();
        $orderId = $this->obj->save($data, true);
        $order = $this->obj->load($orderId);
        $actualStudentId = $order->student_id;
        $expectedStudentId = $data['student_id'];
        $this->assertEquals($expectedStudentId, $actualStudentId);

    }

    public function test_save()
    {
        $data = $this->create_order();
        $actual = $this->obj->save($data);
        $expected = true;
        $this->assertEquals($expected, $actual);
    }


}