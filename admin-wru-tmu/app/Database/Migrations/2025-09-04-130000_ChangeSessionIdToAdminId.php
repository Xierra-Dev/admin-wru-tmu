<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeSessionIdToAdminId extends Migration
{
    public function up()
    {
        // Modify tmp_mloc table
        if ($this->db->fieldExists('session_id', 'tmp_mloc')) {
            // First, get current session_id data and convert to admin_id
            $db = \Config\Database::connect();
            
            // Clear any existing tmp_mloc data that has NULL session_id
            $db->table('tmp_mloc')->where('session_id IS NULL')->delete();
            
            // For existing records with session_id, we'll set a default admin_id
            // In a real scenario, you'd map session_ids to admin_ids properly
            $db->table('tmp_mloc')->where('session_id IS NOT NULL')->update(['session_id' => '4']); // Default to admin_id 4
            
            // Drop the session_id column and add admin_id
            $this->forge->dropColumn('tmp_mloc', 'session_id');
            
            $this->forge->addColumn('tmp_mloc', [
                'admin_id' => [
                    'type' => 'INT',
                    'constraint' => 10,
                    'unsigned' => true,
                    'null' => false,
                    'after' => 'letter'
                ]
            ]);
            
            // Add foreign key constraint
            $this->forge->addForeignKey('admin_id', 'admin', 'id', 'CASCADE', 'CASCADE', 'fk_tmp_mloc_admin');
        }
        
        // Modify tmp_vtrip table
        if ($this->db->fieldExists('session_id', 'tmp_vtrip')) {
            // Clear any existing tmp_vtrip data that has NULL session_id
            $db->table('tmp_vtrip')->where('session_id IS NULL')->delete();
            
            // For existing records with session_id, we'll set a default admin_id
            $db->table('tmp_vtrip')->where('session_id IS NOT NULL')->update(['session_id' => '4']); // Default to admin_id 4
            
            // Drop the session_id column and add admin_id
            $this->forge->dropColumn('tmp_vtrip', 'session_id');
            
            $this->forge->addColumn('tmp_vtrip', [
                'admin_id' => [
                    'type' => 'INT',
                    'constraint' => 10,
                    'unsigned' => true,
                    'null' => false,
                    'after' => 'return_date'
                ]
            ]);
            
            // Add foreign key constraint
            $this->forge->addForeignKey('admin_id', 'admin', 'id', 'CASCADE', 'CASCADE', 'fk_tmp_vtrip_admin');
        }
    }

    public function down()
    {
        // Revert tmp_mloc table
        if ($this->db->fieldExists('admin_id', 'tmp_mloc')) {
            // Drop foreign key first
            $this->forge->dropForeignKey('tmp_mloc', 'fk_tmp_mloc_admin');
            
            // Drop admin_id column and add back session_id
            $this->forge->dropColumn('tmp_mloc', 'admin_id');
            
            $this->forge->addColumn('tmp_mloc', [
                'session_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 128,
                    'null' => true,
                    'after' => 'letter'
                ]
            ]);
        }
        
        // Revert tmp_vtrip table
        if ($this->db->fieldExists('admin_id', 'tmp_vtrip')) {
            // Drop foreign key first
            $this->forge->dropForeignKey('tmp_vtrip', 'fk_tmp_vtrip_admin');
            
            // Drop admin_id column and add back session_id
            $this->forge->dropColumn('tmp_vtrip', 'admin_id');
            
            $this->forge->addColumn('tmp_vtrip', [
                'session_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 128,
                    'null' => true,
                    'after' => 'return_date'
                ]
            ]);
        }
    }
}