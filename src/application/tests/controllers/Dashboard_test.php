<?php

class Dashboard_test extends TestCase
{

    public function test_dashboard_index()
    {
        $this->request('GET', 'admin/dashboard');
        $this->assertResponseCode(200);
    }


}