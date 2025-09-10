<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToPeopleTable extends Migration
{
    public function up()
    {
        // Check if the column already exists
        if (!$this->db->fieldExists('deleted_at', 'people')) {
            $this->forge->addColumn('people', [
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'updated_at'
                ]
            ]);
        }
    }

    public function down()
    {
        // Drop the deleted_at column if it exists
        if ($this->db->fieldExists('deleted_at', 'people')) {
            $this->forge->dropColumn('people', 'deleted_at');
        }
    }
}