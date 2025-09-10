<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameColumnsToSnakeCase extends Migration
{
    public function up()
    {
        // Rename columns in m_loc table to snake_case
        if ($this->db->fieldExists('requestBy', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'requestBy' => [
                    'name' => 'request_by',
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('leaveDate', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'leaveDate' => [
                    'name' => 'leave_date',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('returnDate', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'returnDate' => [
                    'name' => 'return_date',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        // Rename columns in tmp_mloc table to snake_case
        if ($this->db->fieldExists('requestBy', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'requestBy' => [
                    'name' => 'request_by',
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('leaveDate', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'leaveDate' => [
                    'name' => 'leave_date',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('returnDate', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'returnDate' => [
                    'name' => 'return_date',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        // Ensure tmp_mloc has updated_at column like m_loc
        if (!$this->db->fieldExists('updated_at', 'tmp_mloc')) {
            $this->forge->addColumn('tmp_mloc', [
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at'
                ]
            ]);
        }
        
        // Ensure tmp_mloc has deleted_at column like m_loc
        if (!$this->db->fieldExists('deleted_at', 'tmp_mloc')) {
            $this->forge->addColumn('tmp_mloc', [
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
        // Revert column names back to camelCase in m_loc table
        if ($this->db->fieldExists('request_by', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'request_by' => [
                    'name' => 'requestBy',
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('leave_date', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'leave_date' => [
                    'name' => 'leaveDate',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('return_date', 'm_loc')) {
            $this->forge->modifyColumn('m_loc', [
                'return_date' => [
                    'name' => 'returnDate',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        // Revert column names back to camelCase in tmp_mloc table
        if ($this->db->fieldExists('request_by', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'request_by' => [
                    'name' => 'requestBy',
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('leave_date', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'leave_date' => [
                    'name' => 'leaveDate',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        if ($this->db->fieldExists('return_date', 'tmp_mloc')) {
            $this->forge->modifyColumn('tmp_mloc', [
                'return_date' => [
                    'name' => 'returnDate',
                    'type' => 'DATETIME',
                    'null' => false,
                ]
            ]);
        }
        
        // Remove the added columns
        if ($this->db->fieldExists('updated_at', 'tmp_mloc')) {
            $this->forge->dropColumn('tmp_mloc', 'updated_at');
        }
        
        if ($this->db->fieldExists('deleted_at', 'tmp_mloc')) {
            $this->forge->dropColumn('tmp_mloc', 'deleted_at');
        }
    }
}
