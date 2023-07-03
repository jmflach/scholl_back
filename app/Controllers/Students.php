<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Students extends ResourceController {
    private $studentsModel;
    private $token = '123456789abcdefghi';

    public function __construct()
    {
        $this->studentsModel = new \App\Models\StudentsModel();
    }

    private function _validateToken()
    {
        return $this->request->getHeaderLine('token') == $this->token;
    }

    // Service to return all students (GET)
    public function list()
    {
        $data = $this->studentsModel->findAll();    // SELECT * FROM students

        return $this->response->setJSON($data);
    }

    // Service to add new student (POST)
    public function create()
    {
        $response = [];

        // Validate the token
        if($this->_validateToken() == true){
            $newStudent['nome'] = $this->request->getPost('nome');
            $newStudent['sobrenome'] = $this->request->getPost('sobrenome');
            $newStudent['email'] = $this->request->getPost('email');
            $newStudent['telefone'] = $this->request->getPost('telefone');
            $newStudent['endereço'] = $this->request->getPost('endereço');
            $newStudent['nascimento'] = $this->request->getPost('nascimento');
            $newStudent['foto'] = $this->request->getPost('foto');

            try{
                if($this->studentsModel->insert($newStudent))
                {
                    $response = [
                        'response' => 'success',
                        'msg' => 'Student Added'
                    ];
                }
                else{
                    $response = [
                        'response' => 'error',
                        'msg' => 'Error Adding Student',
                        'errors' => $this->studentsModel->errors()
                    ];
                }
            }
            catch (Exception $e){
                $response = [
                    'response' => 'error',
                    'msg' => 'Error Adding Student',
                    'errors' => [
                        'exception' => $e->getMessage()
                    ]
                ];
            }
        }
        else {
            $response = [
                'response' => 'error',
                'msg' => 'Invalid Token'
            ];
        }

        return $this->response->setJSON($response);
    }

}