<?php

namespace App\Controllers;


use Exception;

use Helpers\jwtHelper;


class Authentication extends BaseController {

    // Service to return one student by id (GET)
    public function dummyAuth()
    {
        $user = [
            'id' => 1,
            'name' => 'João Flach',
            'email' => 'joaoflach@gmail.com'
        ];

        helper('jwt');

        $response = [
            'user' => $user,
            'token' => generateJWT($user['email'])
        ];

        

        return $this->response->setJSON($response);
    }
}