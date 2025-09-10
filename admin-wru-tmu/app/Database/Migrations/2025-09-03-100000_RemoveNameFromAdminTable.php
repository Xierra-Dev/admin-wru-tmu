<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveNameFromAdminTable extends Migration
{
    public function up()
    {
        // Check if the 'name' column exists before trying to drop it
        if ($this->db->fieldExists('name', 'admin')) {
            $this->forge->dropColumn('admin', 'name');
        }
    }

    public function down()
    {
        // Add the 'name' column back to the admin table (for rollback)
        $fields = [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'after' => 'password'
            ]
        ];
        
        $this->forge->addColumn('admin', $fields);
    }
}