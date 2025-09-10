<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSessionIdToTmpVtrip extends Migration
{
    public function up()
    {
        $fields = [
            'session_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => true,
                'after'      => 'returnDate'
            ],
        ];

        $this->forge->addColumn('tmp_vtrip', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tmp_vtrip', 'session_id');
    }
}