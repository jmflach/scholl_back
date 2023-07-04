<?php

namespace App\Controllers;


use Exception;


class Authentication extends BaseController {

    // Service to return one student by id (GET)
    public function dummyAuth()
    {
        $user = [
            'id' => 1,
            'name' => 'João Flach',
            'email' => 'joaoflach@gmail.com'
        ];


        $response = [
            'user' => $user,
            'token' => '123456789abcdefghi'
        ];

        

        return $this->response->setJSON($response);
    }
}