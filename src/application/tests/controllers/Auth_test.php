<?php

class Auth_test extends TestCase
{
    public function test_sing_in_index()
    {
        $this->request('GET', 'auth/login');
        $this->assertResponseCode(200);
    }

    public function test_sing_up_index()
    {
        $this->request('GET', 'auth/signup');
        $this->assertResponseCode(200);
    }

    public function test_forgot_password_index()
    {
        $this->request('GET', '/auth/forgot_password');
        $this->assertResponseCode(200);
    }


    public function test_method_404()
    {
        $this->request('GET', 'auth/method_not_exist');
        $this->assertResponseCode(404);
    }




}
