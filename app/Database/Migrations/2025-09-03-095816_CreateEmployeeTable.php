<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeeTable extends Migration
{
    public function up()
    {
        // Only create table if it doesn't exist
        if (!$this->db->tableExists('employee')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'employee_id' => [
                    'type' => 'BIGINT',
                    'constraint' => 20,
                    'unsigned' => true,
                ],
                'email' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
            ]);
            
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('employee_id', 'uniq_employee_id');
            $this->forge->addUniqueKey('email', 'uniq_email');
            $this->forge->createTable('employee');
            
            // Insert initial employee data
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

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
