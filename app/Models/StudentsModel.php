<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentsModel extends Model {
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'sobrenome', 'email', 'telefone', 'endereço', 'nascimento', 'foto'];
    protected $updatedField = 'updated_at';
}
