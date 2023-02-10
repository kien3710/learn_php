<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumUser extends Migration
{
    public function up()
    {
        $fields = [
            'sdt' => ['type' => 'INT' , 'after' => 'email', 'constraint' => "11"],
           
        ];
        $this->forge->addColumn('user', $fields);
        
    }

    public function down()
    {
        //
    }
}
