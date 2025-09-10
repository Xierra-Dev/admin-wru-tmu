<?php

namespace App\Controllers;

use App\Models\VehicleModel;
use App\Models\TmpVehicleModel;
use CodeIgniter\Controller;

class Vehicles extends BaseController
{
    protected $vehicleModel;
    protected $tmpVehicleModel;
    protected $session;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
        $this->tmpVehicleModel = new TmpVehicleModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Check if user is logged in
        

        // Get vehicles with pagination
        $vehicles = $this->vehicleModel->paginate(10);
        $pager = $this->vehicleModel->pager;

        // Get temporary vehicles data for current admin
        $tmp_vehicles = $this->tmpVehicleModel->getAllForCurrentAdmin();

        $data = [
            'vehicles' => $vehicles,
            'pager' => $pager,
            'tmp_vehicles' => $tmp_vehicles,
            'title' => 'Vehicle Management'
        ];

        return view('vehicles/index', $data);
    }

    public function store()
    {
        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_name' => 'required|min_length[3]|max_length[255]',
            'number_plate' => 'required|min_length[3]|max_length[255]|is_unique[vehicle.number_plate]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        $data = [
            'vehicle_name' => $this->request->getPost('vehicle_name'),
            'number_plate' => $this->request->getPost('number_plate'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->vehicleModel->insert($data)) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully added...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to add vehicle');
            return redirect()->back()->withInput();
        }
    }

    public function update($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle ID is required');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if vehicle exists
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle not found');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_name' => 'required|min_length[3]|max_length[255]',
            'number_plate' => "required|min_length[3]|max_length[255]|is_unique[vehicle.number_plate,id,{$id}]"
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $validation->getErrors()));
            return redirect()->back()->withInput();
        }

        $data = [
            'vehicle_name' => $this->request->getPost('vehicle_name'),
            'number_plate' => $this->request->getPost('number_plate'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->vehicleModel->update($id, $data)) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully edited...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to update vehicle');
            return redirect()->back()->withInput();
        }
    }

    public function updateSingle()
    {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle ID is required');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if vehicle exists
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle not found');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Validation rules (without is_unique since we're editing)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_name' => 'required|min_length[3]|max_length[255]',
            'number_plate' => "required|min_length[3]|max_length[255]|is_unique[vehicle.number_plate,id,{$id}]"
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $validation->getErrors()));
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $data = [
            'vehicle_name' => $this->request->getPost('vehicle_name'),
            'number_plate' => $this->request->getPost('number_plate'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->vehicleModel->update($id, $data)) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully edited...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to update vehicle');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function delete($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle ID is required');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if vehicle exists
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle not found');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $db = \Config\Database::connect();
        $deletedAt = date('Y-m-d H:i:s');
        
        // Start transaction for cascade delete
        $db->transStart();
        
        try {
            // Check and cascade soft delete related records
            $vtripCount = $db->table('v_trip')->where('vehicle_id', $id)->where('deleted_at IS NULL')->update(['deleted_at' => $deletedAt]);
            
            // Hard delete temporary records
            $tmpVtripCount = $db->table('tmp_vtrip')->where('vehicle_id', $id)->delete();
            
            // Finally, soft delete the vehicle - use direct database update to avoid validation issues
            $vehicleUpdateResult = $db->table('vehicle')->where('id', $id)->update(['deleted_at' => $deletedAt, 'updated_at' => $deletedAt]);
            
            $db->transComplete();
            
            if ($db->transStatus() === false || !$vehicleUpdateResult) {
                $db->transRollback();
                log_message('error', 'Transaction failed during vehicle deletion. Vehicle ID: ' . $id);
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Failed to delete vehicle - transaction error');
                return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }
            
            // Prepare success message with cascade information
            $messages = ["Vehicle '{$vehicle['vehicle_name']}' deleted successfully"];
            
            if ($vtripCount > 0) {
                $messages[] = "Cascade deleted {$vtripCount} related V-Trip record(s)";
            }
            
            if ($tmpVtripCount > 0) {
                $messages[] = "Removed {$tmpVtripCount} temporary V-Trip record(s)";
            }
            
            $successMessage = implode('. ', $messages);
            log_message('info', 'Vehicle deleted successfully: ' . $successMessage);
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully deleted...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error deleting vehicle (ID: ' . $id . '): ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'An error occurred while deleting the vehicle: ' . $e->getMessage());
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }
    
    public function deleteWithoutCascade($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle ID is required');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if vehicle exists
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Vehicle not found');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
        
        // Check for foreign key constraints
        $db = \Config\Database::connect();
        
        // Check V-Trip references
        $vtripCount = $db->table('v_trip')->where('vehicle_id', $id)->where('deleted_at IS NULL')->countAllResults();
        
        if ($vtripCount > 0) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', "Cannot delete vehicle '{$vehicle['vehicle_name']}'. It is referenced by {$vtripCount} V-Trip record(s). Use cascade delete or remove references first.");
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
        
        // Proceed with simple delete if no constraints
        $this->vehicleModel->skipValidation(true);
        if ($this->vehicleModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')])) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully deleted...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to delete vehicle');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function debugDelete($id = null)
    {
        if (!$id) {
            echo "<h2>Error: Vehicle ID is required</h2>";
            return;
        }

        echo "<h2>Vehicle Delete Debug</h2>";
        echo "<p>Vehicle ID: {$id}</p>";
        
        // Check if vehicle exists
        $vehicle = $this->vehicleModel->find($id);
        if (!$vehicle) {
            echo "<p style='color: red;'>Vehicle not found</p>";
            return;
        }
        
        echo "<h3>Vehicle Details:</h3>";
        echo "<pre>";
        print_r($vehicle);
        echo "</pre>";
        
        // Check related V-Trip records
        $db = \Config\Database::connect();
        $vtripRecords = $db->table('v_trip')->where('vehicle_id', $id)->where('deleted_at IS NULL')->get()->getResultArray();
        
        echo "<h3>Related V-Trip Records (" . count($vtripRecords) . "):</h3>";
        echo "<pre>";
        print_r($vtripRecords);
        echo "</pre>";
        
        // Check temporary V-Trip records
        $tmpVtripRecords = $db->table('tmp_vtrip')->where('vehicle_id', $id)->get()->getResultArray();
        
        echo "<h3>Temporary V-Trip Records (" . count($tmpVtripRecords) . "):</h3>";
        echo "<pre>";
        print_r($tmpVtripRecords);
        echo "</pre>";
        
        // Test direct database update
        echo "<h3>Test Direct Database Update:</h3>";
        try {
            $updateResult = $db->table('vehicle')
                              ->where('id', $id)
                              ->update(['updated_at' => date('Y-m-d H:i:s')]);
            
            echo "<p style='color: green;'>Direct update test successful: " . ($updateResult ? 'true' : 'false') . "</p>";
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Direct update test failed: " . $e->getMessage() . "</p>";
        }
        
        // Test model update
        echo "<h3>Test Model Update:</h3>";
        try {
            $this->vehicleModel->skipValidation(true);
            $modelUpdateResult = $this->vehicleModel->update($id, ['updated_at' => date('Y-m-d H:i:s')]);
            echo "<p style='color: green;'>Model update test successful: " . ($modelUpdateResult ? 'true' : 'false') . "</p>";
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Model update test failed: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><a href='" . base_url('vehicles') . "'>Back to Vehicles</a></p>";
    }

    public function createTestVehicle()
    {
        echo "<h2>Creating Test Vehicle</h2>";
        
        $testData = [
            'vehicle_name' => 'Test Vehicle ' . date('Y-m-d H:i:s'),
            'number_plate' => 'TEST-' . date('His'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $insertId = $this->vehicleModel->insert($testData);
            
            if ($insertId) {
                echo "<p style='color: green;'>Test vehicle created successfully with ID: {$insertId}</p>";
                echo "<p>Vehicle Name: {$testData['vehicle_name']}</p>";
                echo "<p>Number Plate: {$testData['number_plate']}</p>";
                echo "<p><a href='" . base_url('vehicles/delete/' . $insertId) . "'>Test Delete</a></p>";
                echo "<p><a href='" . base_url('vehicles/debugDelete/' . $insertId) . "'>Debug Delete</a></p>";
            } else {
                echo "<p style='color: red;'>Failed to create test vehicle</p>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error creating test vehicle: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><a href='" . base_url('vehicles') . "'>Back to Vehicles</a></p>";
    }

    public function addTmp()
    {
        // Check if request is AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_name' => 'required|min_length[3]|max_length[255]',
            'number_plate' => 'required|min_length[3]|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $data = [
            'vehicle_name' => $this->request->getPost('vehicle_name'),
            'number_plate' => $this->request->getPost('number_plate'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insertId = $this->tmpVehicleModel->insert($data);
        
        if ($insertId) {
            $newData = $this->tmpVehicleModel->find($insertId);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Vehicle added to temporary list',
                'data' => $newData
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add vehicle to temporary list'
            ]);
        }
    }

    public function removeTmp($id = null)
    {
        // Check if request is AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        if (!$id) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID is required']);
        }

        // Check if temporary vehicle exists
        $tmpVehicle = $this->tmpVehicleModel->find($id);
        if (!$tmpVehicle) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Temporary vehicle not found']);
        }

        if ($this->tmpVehicleModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Vehicle removed from temporary list'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to remove vehicle from temporary list'
            ]);
        }
    }

    public function saveVehicles()
    {
        // Get all temporary vehicles for current admin
        $tmpVehicles = $this->tmpVehicleModel->getAllForCurrentAdmin();
        
        // Get current input from form if exists
        $currentName = $this->request->getPost('current_name');
        $currentPlate = $this->request->getPost('current_plate');
        
        $allVehicles = [];
        
        // Add temporary vehicles to the list
        foreach ($tmpVehicles as $tmp) {
            $allVehicles[] = [
                'vehicle_name' => $tmp['vehicle_name'],
                'number_plate' => $tmp['number_plate'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        // Add current input if provided
        if ($currentName && $currentPlate) {
            $allVehicles[] = [
                'vehicle_name' => $currentName,
                'number_plate' => $currentPlate,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        if (empty($allVehicles)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'No vehicles to save');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Insert all vehicles
            foreach ($allVehicles as $vehicleData) {
                // Check for duplicate number plates
                $existing = $this->vehicleModel->where('number_plate', $vehicleData['number_plate'])->first();
                if ($existing) {
                    $db->transRollback();
                    session()->setFlashdata('notification_type', 'danger');
                    session()->setFlashdata('notification_message', 'Number plate ' . $vehicleData['number_plate'] . ' already exists');
                    return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
                }
                
                $this->vehicleModel->insert($vehicleData);
            }

            // Clear temporary vehicles for current admin
            $this->tmpVehicleModel->clearAllForCurrentAdmin();

            $db->transComplete();

            if ($db->transStatus() === false) {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Failed to save vehicles');
                return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }

            $count = count($allVehicles);
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully added...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error saving vehicles: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'An error occurred while saving vehicles');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function clearTmp()
    {
        if ($this->tmpVehicleModel->clearAllForCurrentAdmin()) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully deleted...');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to clear temporary vehicle list');
            return redirect()->to('vehicles' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function addQuick()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not authenticated'
            ]);
        }

        $input = json_decode($this->request->getBody(), true);
        $vehicleName = trim($input['vehicle_name'] ?? '');
        $numberPlate = trim($input['number_plate'] ?? '');

        // Validate input
        if (empty($vehicleName)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Vehicle name is required'
            ]);
        }

        if (empty($numberPlate)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Number plate is required'
            ]);
        }

        if (strlen($vehicleName) < 2 || strlen($vehicleName) > 100) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Vehicle name must be between 2 and 100 characters'
            ]);
        }

        if (strlen($numberPlate) < 2 || strlen($numberPlate) > 20) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Number plate must be between 2 and 20 characters'
            ]);
        }

        // Check for duplicates
        $existingName = $this->vehicleModel->where('vehicle_name', $vehicleName)
                                          ->where('deleted_at', null)
                                          ->first();

        if ($existingName) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Vehicle name already exists'
            ]);
        }

        $existingPlate = $this->vehicleModel->where('number_plate', $numberPlate)
                                           ->where('deleted_at', null)
                                           ->first();

        if ($existingPlate) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Number plate already exists'
            ]);
        }

        $data = [
            'vehicle_name' => $vehicleName,
            'number_plate' => $numberPlate
        ];

        try {
            if ($this->vehicleModel->insert($data)) {
                $insertedId = $this->vehicleModel->getInsertID();
                
                // Get the inserted vehicle
                $newVehicle = $this->vehicleModel->find($insertedId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Vehicle added successfully',
                    'vehicle' => [
                        'id' => $newVehicle['id'],
                        'vehicle_name' => $newVehicle['vehicle_name'],
                        'number_plate' => $newVehicle['number_plate']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add vehicle'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding quick vehicle: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while adding the vehicle'
            ]);
        }
    }
}