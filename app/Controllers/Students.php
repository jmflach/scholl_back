<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Exception;

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

    // Service to return one student by id (GET)
    public function getStudent($id)
    {
        $response = [];

        try {

            $model = $this->studentsModel;
            $student = $model->findStudentById($id);

            $response = [
                'response' => 'success',
                'student' => $student
            ];

        } catch (Exception $e) {
            $response = [
                'response' => 'error',
                    'msg' => 'Error Adding Student',
                    'errors' => [
                        'exception' => $e->getMessage()
                    ]
            ];
        }

        return $this->response->setJSON($response);
    }

    // Service to add new student (POST)
    public function create()
    {
        $response = [];


        $newStudent['nome'] = $this->request->getPost('nome');
        $newStudent['sobrenome'] = $this->request->getPost('sobrenome');
        $newStudent['email'] = $this->request->getPost('email');
        $newStudent['telefone'] = $this->request->getPost('telefone');
        $newStudent['endereço'] = $this->request->getPost('endereço');
        $newStudent['nascimento'] = $this->request->getPost('nascimento');
        $newStudent['foto'] = $this->request->getPost('foto');

        try{
            $this->studentsModel->insert($newStudent);
            $response = [
                'response' => 'success',
                'msg' => 'Student Added'
            ];
        } catch (Exception $e) {
            $response = [
                'response' => 'error',
                'msg' => 'Error Adding Student',
                'errors' => [
                    'exception' => $e->getMessage()
                ]
            ];
        }

        return $this->response->setJSON($response);
    }

    // Service to update a student (POST)
    public function update($id = null)
    {
        try {

            $model = $this->studentsModel;
            $model->findStudentById($id);

            $updatedStudent['nome'] = $this->request->getPost('nome');
            $updatedStudent['sobrenome'] = $this->request->getPost('sobrenome');
            $updatedStudent['email'] = $this->request->getPost('email');
            $updatedStudent['telefone'] = $this->request->getPost('telefone');
            $updatedStudent['endereço'] = $this->request->getPost('endereço');
            $updatedStudent['nascimento'] = $this->request->getPost('nascimento');
            $updatedStudent['foto'] = $this->request->getPost('foto');
          

            $model->update($id, $updatedStudent);
            $student = $model->findStudentById($id);

            $response =[
                    'message' => 'Student updated successfully',
                    'student' => $student
            ];
        } catch (Exception $e) {
            $response =[
                'response' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

    // Service to delete a student (DELETE)
    public function destroy($id)
    {
        try {

            $model = $this->studentsModel;
            $student = $model->findStudentById($id);
            $model->delete($student);

            $response =[
                'response' => 'success',
                'message' => 'Student deleted'
            ];

        } catch (Exception $e) {
            $response =[
                'response' => 'error',
                'message' => $e->getMessage()
            ];
        }

        return $this->response->setJSON($response);
    }

}