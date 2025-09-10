<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyVtripTables extends Migration
{
    public function up()
    {
        // Modify v_trip table
        // Drop requestBy column
        $this->forge->dropColumn('v_trip', 'requestBy');
        
        // Rename columns in v_trip table
        $fields = [
            'leaveDate' => [
                'name' => 'leave_date',
                'type' => 'datetime',
                'null' => false
            ],
            'returnDate' => [
                'name' => 'return_date', 
                'type' => 'datetime',
                'null' => false
            ]
        ];
        $this->forge->modifyColumn('v_trip', $fields);
        
        // Modify tmp_vtrip table
        // Drop requestBy column
        $this->forge->dropColumn('tmp_vtrip', 'requestBy');
        
        // Rename columns in tmp_vtrip table
        $fields = [
            'leaveDate' => [
                'name' => 'leave_date',
                'type' => 'datetime',
                'null' => false
            ],
            'returnDate' => [
                'name' => 'return_date',
                'type' => 'datetime',
                'null' => false
            ]
        ];
        $this->forge->modifyColumn('tmp_vtrip', $fields);
        
        // Drop old indexes and create new ones for v_trip
        $this->forge->dropKey('v_trip', 'idx_vtrip_leaveDate');
        $this->forge->dropKey('v_trip', 'idx_vtrip_returnDate');
        
        $this->forge->addKey('leave_date', false, false, 'idx_vtrip_leave_date');
        $this->forge->addKey('return_date', false, false, 'idx_vtrip_return_date');
        $this->forge->processIndexes('v_trip');
    }

    public function down()
    {
        // Reverse the changes for v_trip table
        // Add back requestBy column
        $fields = [
            'requestBy' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '-',
                'after' => 'destination_id'
            ]
        ];
        $this->forge->addColumn('v_trip', $fields);
        
        // Rename columns back in v_trip table
        $fields = [
            'leave_date' => [
                'name' => 'leaveDate',
                'type' => 'datetime',
                'null' => false
            ],
            'return_date' => [
                'name' => 'returnDate',
                'type' => 'datetime', 
                'null' => false
            ]
        ];
        $this->forge->modifyColumn('v_trip', $fields);
        
        // Reverse the changes for tmp_vtrip table
        // Add back requestBy column
        $fields = [
            'requestBy' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '-',
                'after' => 'destination_id'
            ]
        ];
        $this->forge->addColumn('tmp_vtrip', $fields);
        
        // Rename columns back in tmp_vtrip table
        $fields = [
            'leave_date' => [
                'name' => 'leaveDate',
                'type' => 'datetime',
                'null' => false
            ],
            'return_date' => [
                'name' => 'returnDate',
                'type' => 'datetime',
                'null' => false
            ]
        ];
        $this->forge->modifyColumn('tmp_vtrip', $fields);
        
        // Restore old indexes for v_trip
        $this->forge->dropKey('v_trip', 'idx_vtrip_leave_date');
        $this->forge->dropKey('v_trip', 'idx_vtrip_return_date');
        
        $this->forge->addKey('leaveDate', false, false, 'idx_vtrip_leaveDate');
        $this->forge->addKey('returnDate', false, false, 'idx_vtrip_returnDate');
        $this->forge->processIndexes('v_trip');
    }
}