<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameVehicleColumns extends Migration
{
    public function up()
    {
        // Rename numberPlate to number_plate in vehicle table
        $this->forge->modifyColumn('vehicle', [
            'numberPlate' => [
                'name' => 'number_plate',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);

        // Rename vehicleID to number_plate in tmp_vehicle table
        $this->forge->modifyColumn('tmp_vehicle', [
            'vehicleID' => [
                'name' => 'number_plate',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        
        // Update indexes for vehicle table
        $this->forge->dropKey('vehicle', 'idx_vehicle_numberPlate');
        $this->forge->addKey('number_plate', 'idx_vehicle_number_plate');
        
        // Update indexes for tmp_vehicle table  
        $this->forge->dropKey('tmp_vehicle', 'idx_tmp_vehicle_vehicleID');
        $this->forge->addKey('number_plate', 'idx_tmp_vehicle_number_plate');
    }

    public function down()
    {
        // Revert number_plate to numberPlate in vehicle table
        $this->forge->modifyColumn('vehicle', [
            'number_plate' => [
                'name' => 'numberPlate',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);

        // Revert number_plate to vehicleID in tmp_vehicle table
        $this->forge->modifyColumn('tmp_vehicle', [
            'number_plate' => [
                'name' => 'vehicleID',
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        
        // Revert indexes for vehicle table
        $this->forge->dropKey('vehicle', 'idx_vehicle_number_plate');
        $this->forge->addKey('numberPlate', 'idx_vehicle_numberPlate');
        
        // Revert indexes for tmp_vehicle table
        $this->forge->dropKey('tmp_vehicle', 'idx_tmp_vehicle_number_plate');
        $this->forge->addKey('vehicleID', 'idx_tmp_vehicle_vehicleID');
    }
}