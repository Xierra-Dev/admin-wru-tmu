<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminIdToRemainingTmpTables extends Migration
{
    public function up()
    {
        // Add admin_id to tmp_people table
        if ($this->db->tableExists('tmp_people')) {
            if (!$this->db->fieldExists('admin_id', 'tmp_people')) {
                $this->forge->addColumn('tmp_people', [
                    'admin_id' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'unsigned' => true,
                        'null' => false,
                        'after' => 'name'
                    ]
                ]);
                
                // Add foreign key constraint
                $this->forge->addForeignKey('admin_id', 'admin', 'id', 'CASCADE', 'CASCADE', 'fk_tmp_people_admin');
            }
        }
        
        // Add admin_id to tmp_vehicle table  
        if ($this->db->tableExists('tmp_vehicle')) {
            if (!$this->db->fieldExists('admin_id', 'tmp_vehicle')) {
                $this->forge->addColumn('tmp_vehicle', [
                    'admin_id' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'unsigned' => true,
                        'null' => false,
                        'after' => 'number_plate'
                    ]
                ]);
                
                // Add foreign key constraint
                $this->forge->addForeignKey('admin_id', 'admin', 'id', 'CASCADE', 'CASCADE', 'fk_tmp_vehicle_admin');
            }
        }
        
        // Add admin_id to tmp_destination table
        if ($this->db->tableExists('tmp_destination')) {
            if (!$this->db->fieldExists('admin_id', 'tmp_destination')) {
                $this->forge->addColumn('tmp_destination', [
                    'admin_id' => [
                        'type' => 'INT',
                        'constraint' => 10,
                        'unsigned' => true,
                        'null' => false,
                        'after' => 'destination_name'
                    ]
                ]);
                
                // Add foreign key constraint
                $this->forge->addForeignKey('admin_id', 'admin', 'id', 'CASCADE', 'CASCADE', 'fk_tmp_destination_admin');
            }
        }
        
        // Clear existing data from these tables since they won't have admin_id values
        // and set default admin_id for any existing records (if needed)
        $db = \Config\Database::connect();
        
        // For safety, we'll clear all existing tmp data since they don't have admin_id
        $db->table('tmp_people')->truncate();
        $db->table('tmp_vehicle')->truncate();
        $db->table('tmp_destination')->truncate();
    }

    public function down()
    {
        // Remove admin_id from tmp_people table
        if ($this->db->tableExists('tmp_people') && $this->db->fieldExists('admin_id', 'tmp_people')) {
            $this->forge->dropForeignKey('tmp_people', 'fk_tmp_people_admin');
            $this->forge->dropColumn('tmp_people', 'admin_id');
        }
        
        // Remove admin_id from tmp_vehicle table
        if ($this->db->tableExists('tmp_vehicle') && $this->db->fieldExists('admin_id', 'tmp_vehicle')) {
            $this->forge->dropForeignKey('tmp_vehicle', 'fk_tmp_vehicle_admin');
            $this->forge->dropColumn('tmp_vehicle', 'admin_id');
        }
        
        // Remove admin_id from tmp_destination table
        if ($this->db->tableExists('tmp_destination') && $this->db->fieldExists('admin_id', 'tmp_destination')) {
            $this->forge->dropForeignKey('tmp_destination', 'fk_tmp_destination_admin');
            $this->forge->dropColumn('tmp_destination', 'admin_id');
        }
    }
}