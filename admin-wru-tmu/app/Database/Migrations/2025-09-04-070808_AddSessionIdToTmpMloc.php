<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSessionIdToTmpMloc extends Migration
{
    public function up()
    {
        // Add session_id column to tmp_mloc table if it doesn't exist
        if (!$this->db->fieldExists('session_id', 'tmp_mloc')) {
            $this->forge->addColumn('tmp_mloc', [
                'session_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 128,
                    'null' => true,
                    'after' => 'letter'
                ]
            ]);
        }
    }

    public function down()
    {
        // Remove session_id column if it exists
        if ($this->db->fieldExists('session_id', 'tmp_mloc')) {
            $this->forge->dropColumn('tmp_mloc', 'session_id');
        }
    }
}
