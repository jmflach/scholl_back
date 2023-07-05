<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => false
            ],
            'sobrenome' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => false
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => false,
                'unique' => true
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
            ],
            'endereço' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => false,
            ],
            'nascimento' => [
                'type' => 'date',
                'null' => false,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '1000000',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
