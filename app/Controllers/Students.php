<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Students extends ResourceController {
    private $studentsModel;

    public function __construct()
    {
        $this->studentsModel = new \App\Models\StudentsModel();
    }

    // Service to return all students (GET)
    public function list()
    {
        $data = $this->studentsModel->findAll();    // SELECT * FROM students

        return $this->response->setJSON($data);
    }

}