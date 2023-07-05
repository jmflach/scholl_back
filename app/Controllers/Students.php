<?php

namespace App\Controllers;


use Exception;


class Students extends BaseController {
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
        log_message("debug", "Listing students");

        $data = $this->studentsModel->findAll();    // SELECT * FROM students

        // return $this->response->setJSON($data);
        return $this->getResponse($data);
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
        log_message("debug", "Creating new student");
        $response = [];

        $input = $this->getRequestInput($this->request);

        $newStudent['nome'] = $input['nome'];
        $newStudent['sobrenome'] = $input['sobrenome'];
        $newStudent['email'] = $input['email'];
        $newStudent['telefone'] = $input['telefone'];
        $newStudent['endereço'] = $input['endereço'];
        $newStudent['nascimento'] = $input['nascimento'];
        $newStudent['foto'] = $input['foto'];

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
        log_message("debug", "Updating Student");
        try {

            $model = $this->studentsModel;
            $model->findStudentById($id);

            $input = $this->getRequestInput($this->request);

       
            $updatedStudent['nome'] = $input['nome'];
            $updatedStudent['sobrenome'] = $input['sobrenome'];
            $updatedStudent['email'] = $input['email'];
            $updatedStudent['telefone'] = $input['telefone'];
            $updatedStudent['endereço'] = $input['endereço'];
            $updatedStudent['nascimento'] = $input['nascimento'];
            $updatedStudent['foto'] = $input['foto'];
          

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