<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('students')->insert([
            'nome' => "João Marcos",
            'sobrenome' => "Flach",
            'email' => "joaoflach@gmail.com",
            'telefone' => "46991083848",
            'endereço' => "Rua Pai do Afonso, 100",
            'nascimento' => "1993-12-15",
            'foto' => "https://img.freepik.com/fotos-gratis/vista-frontal-sorriso-menino-vestindo-camiseta-amarela_23-2148356653.jpg?w=740&t=st=1688262219~exp=1688262819~hmac=95832ba01abeb0bc3f3885e84a2c47bae8e5921c468b6b476f3a0d5268efb041",
        ]);

        $this->db->table('students')->insert([
            'nome' => "Izabela Garcia",
            'sobrenome' => "Padilha",
            'email' => "izabelagarcia@gmail.com",
            'telefone' => "46991083847",
            'endereço' => "Rua Pai do Afonso, 100",
            'nascimento' => "1990-12-15",
            'foto' => "https://img.freepik.com/fotos-gratis/retrato-de-uma-jovem-adoravel-posando-em-um-top-fofo_23-2148972074.jpg?w=740&t=st=1688262221~exp=1688262821~hmac=8dbebfc3711f3851b05f2e9cea1c9668cb0b74e8f6a2de7157ad3c4f319aab04",
        ]);

        $this->db->table('students')->insert([
            'nome' => "Brenda",
            'sobrenome' => "Belo",
            'email' => "brendabelo@gmail.com",
            'telefone' => "46999256254",
            'endereço' => "Km 18",
            'nascimento' => "1222-12-15",
            'foto' => "https://img.freepik.com/fotos-gratis/retrato-menina-em-fundo-azul_23-2148356689.jpg?t=st=1688264862~exp=1688265462~hmac=0040bcda8e1f58fb3828a15c943441643a1686b0c6e40e688e92dd3a3c1ea1ca",
        ]);
    }
}
