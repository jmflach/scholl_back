<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class StudentsModel extends Model {
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'sobrenome', 'email', 'telefone', 'endereço', 'nascimento', 'foto'];
    protected $updatedField = 'updated_at';

    public function findStudentById($id)
    {
        $student = $this
            ->asArray()
            ->where(['id' => $id])
            ->first();

        if (!$student) throw new Exception('Could not find student for specified ID');

        return $student;
    }
}