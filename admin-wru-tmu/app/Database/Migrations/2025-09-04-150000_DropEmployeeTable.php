<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropEmployeeTable extends Migration
{
    public function up()
    {
        // Drop the employee table since we're now using external database validation
        if ($this->db->tableExists('employee')) {
            $this->forge->dropTable('employee', true);
        }
    }

    public function down()
    {
        // Recreate the employee table in case we need to rollback
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unique' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('employee');
        
        // Re-insert the sample data if needed
        $data = [
            [
                'employee_id' => 2025001,
                'email' => 'ari.wijaya@wru.co.id',
                'created_at' => '2025-09-03 09:36:10',
                'updated_at' => '2025-09-03 09:36:10'
            ],
            [
                'employee_id' => 2025002,
                'email' => 'nadia.putri@wru.co.id',
                'created_at' => '2025-09-03 09:36:20',
                'updated_at' => '2025-09-03 09:36:20'
            ],
            [
                'employee_id' => 2025003,
                'email' => 'bagus.santoso@wru.co.id',
                'created_at' => '2025-09-03 09:36:30',
                'updated_at' => '2025-09-03 09:36:30'
            ],
            [
                'employee_id' => 2025004,
                'email' => 'citra.anindya@wru.co.id',
                'created_at' => '2025-09-03 09:36:40',
                'updated_at' => '2025-09-03 09:36:40'
            ],
            [
                'employee_id' => 2025005,
                'email' => 'muhammad.fikri@wru.co.id',
                'created_at' => '2025-09-03 09:36:50',
                'updated_at' => '2025-09-03 09:36:50'
            ]
        ];
        
        $this->db->table('employee')->insertBatch($data);
    }
}