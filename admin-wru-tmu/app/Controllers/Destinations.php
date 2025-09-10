<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DestinationModel;
use App\Models\TmpDestinationModel;

class Destinations extends BaseController
{
    protected $destinationModel;
    protected $tmpDestinationModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
        $this->tmpDestinationModel = new TmpDestinationModel();
    }

    public function index()
    {
        $pager = \Config\Services::pager();
        
        // Only get non-deleted destinations
        $data = [
            'destinations' => $this->destinationModel->where('deleted_at', null)->paginate(10),
            'pager' => $this->destinationModel->pager,
            'tmp_destinations' => $this->tmpDestinationModel->getAllForCurrentAdmin()
        ];

        return view('destinations/index', $data);
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
        $destinationName = trim($input['destination_name'] ?? '');

        // Validation
        if (empty($destinationName)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Destination name is required'
            ]);
        }

        if (strlen($destinationName) < 2 || strlen($destinationName) > 100) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Destination name must be between 2 and 100 characters'
            ]);
        }

        // Check if destination already exists (only non-deleted)
        $existing = $this->destinationModel
            ->where('destination_name', $destinationName)
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Destination already exists'
            ]);
        }

        // Insert new destination
        $data = [
            'destination_name' => $destinationName
        ];

        try {
            if ($this->destinationModel->insert($data)) {
                $insertedId = $this->destinationModel->getInsertID();
                
                // Get the inserted destination
                $newDestination = $this->destinationModel->find($insertedId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Destination added successfully',
                    'destination' => [
                        'id' => $newDestination['id'],
                        'destination_name' => $newDestination['destination_name']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add destination'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding quick destination: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while adding the destination'
            ]);
        }
    }

    public function addTmp()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        // Check authentication
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Authentication required'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'destination_name' => 'required|min_length[2]|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $destinationName = trim($this->request->getPost('destination_name'));

        // Check if already exists in main table (only non-deleted)
        if ($this->destinationModel->where('destination_name', $destinationName)->where('deleted_at', null)->first()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Destinasi sudah ada'
            ]);
        }

        // Check if already exists in tmp table for current admin
        if ($this->tmpDestinationModel->destinationExistsInTmp($destinationName)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Destinasi sudah ada dalam daftar sementara'
            ]);
        }

        $data = [
            'destination_name' => $destinationName,
            'admin_id' => session()->get('admin_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            if ($this->tmpDestinationModel->insert($data)) {
                $insertedId = $this->tmpDestinationModel->getInsertID();
                
                // Get the inserted data
                $insertedData = $this->tmpDestinationModel->find($insertedId);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil ditambahkan ke daftar sementara',
                    'data' => $insertedData
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data',
                    'errors' => $this->tmpDestinationModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Destinations addTmp error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function removeTmp($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }

        // Check authentication
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Authentication required'
            ]);
        }

        try {
            // Verify the record belongs to current admin before deleting
            $adminId = session()->get('admin_id');
            $tmpData = $this->tmpDestinationModel->where('admin_id', $adminId)->find($id);
            
            if (!$tmpData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan atau tidak memiliki akses'
                ]);
            }

            if ($this->tmpDestinationModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus dari daftar sementara'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menghapus data'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Destinations removeTmp error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function saveDestinations()
    {
        // Get all tmp data for current admin
        $tmpData = $this->tmpDestinationModel->getAllForCurrentAdmin();
        
        // Get current input if any
        $currentName = $this->request->getPost('current_name');
        
        $successCount = 0;
        $errorMessages = [];

        // Process current input first if not empty
        if (!empty($currentName)) {
            $currentName = trim($currentName);
            
            // Validate current input
            if (strlen($currentName) >= 2 && strlen($currentName) <= 100) {
                // Check if not already exists (only non-deleted)
                if (!$this->destinationModel->where('destination_name', $currentName)->where('deleted_at', null)->first()) {
                    if ($this->destinationModel->insert(['destination_name' => $currentName])) {
                        $successCount++;
                    } else {
                        $errorMessages[] = "Gagal menyimpan: {$currentName}";
                    }
                } else {
                    $errorMessages[] = "Destinasi '{$currentName}' sudah ada";
                }
            } else {
                $errorMessages[] = "Nama destinasi '{$currentName}' tidak valid (panjang harus 2-100 karakter)";
            }
        }

        // Process tmp data
        foreach ($tmpData as $tmp) {
            // Double check if not already exists (only non-deleted)
            if (!$this->destinationModel->where('destination_name', $tmp['destination_name'])->where('deleted_at', null)->first()) {
                if ($this->destinationModel->insert(['destination_name' => $tmp['destination_name']])) {
                    $successCount++;
                } else {
                    $errorMessages[] = "Gagal menyimpan: {$tmp['destination_name']}";
                }
            } else {
                $errorMessages[] = "Destinasi '{$tmp['destination_name']}' sudah ada";
            }
        }

        // Clear tmp table for current admin
        $this->tmpDestinationModel->clearAllForCurrentAdmin();

        // Prepare flash message
        if ($successCount > 0) {
            $message = "Berhasil menyimpan {$successCount} destinasi";
            if (!empty($errorMessages)) {
                $message .= ". Peringatan: " . implode(", ", $errorMessages);
            }
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', $message);
        } else {
            $message = "Tidak ada data yang disimpan";
            if (!empty($errorMessages)) {
                $message .= ". Error: " . implode(", ", $errorMessages);
            }
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', $message);
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function update($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'destination_name' => 'required|min_length[2]|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $errors));
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destinationName = $this->request->getPost('destination_name');

        // Check if name already exists (excluding current record)
        $existingDestination = $this->destinationModel
            ->where('destination_name', $destinationName)
            ->where('id !=', $id)
            ->first();

        if ($existingDestination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Nama destinasi sudah ada');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $data = ['destination_name' => $destinationName];
        
        if ($this->destinationModel->update($id, $data)) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully edited...');
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Gagal memperbarui destinasi');
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function updateSingle()
    {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'destination_name' => 'required|min_length[2]|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $errors));
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destinationName = $this->request->getPost('destination_name');

        // Check if name already exists (excluding current record, only non-deleted)
        $existingDestination = $this->destinationModel
            ->where('destination_name', $destinationName)
            ->where('id !=', $id)
            ->where('deleted_at', null)
            ->first();

        if ($existingDestination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Nama destinasi sudah ada');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $data = ['destination_name' => $destinationName];
        
        if ($this->destinationModel->update($id, $data)) {
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully edited...');
        } else {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Gagal memperbarui destinasi');
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function delete($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Log the destination being deleted for debugging
        log_message('info', "Attempting to delete destination ID {$id}: {$destination['destination_name']}");

        try {
            $db = \Config\Database::connect();
            $db->transStart();

            // Get current datetime for soft delete
            $deletedAt = date('Y-m-d H:i:s');
            
            // Cascade soft delete related records
            $cascadeResults = [];
            
            // 1. Soft delete related m_loc records
            $mlocCount = $db->table('m_loc')
                           ->where('destination_id', $id)
                           ->where('deleted_at IS NULL')
                           ->update(['deleted_at' => $deletedAt, 'updated_at' => $deletedAt]);
            $cascadeResults['m_loc'] = $db->affectedRows();
            
            // 2. Soft delete related v_trip records
            $vtripCount = $db->table('v_trip')
                            ->where('destination_id', $id)
                            ->where('deleted_at IS NULL')
                            ->update(['deleted_at' => $deletedAt, 'updated_at' => $deletedAt]);
            $cascadeResults['v_trip'] = $db->affectedRows();
            
            // 3. Delete related tmp_mloc records (hard delete since no soft delete)
            $tmpMlocCount = $db->table('tmp_mloc')
                              ->where('destination_id', $id)
                              ->delete();
            $cascadeResults['tmp_mloc'] = $db->affectedRows();
            
            // 4. Delete related tmp_vtrip records (hard delete since no soft delete)
            $tmpVtripCount = $db->table('tmp_vtrip')
                               ->where('destination_id', $id)
                               ->delete();
            $cascadeResults['tmp_vtrip'] = $db->affectedRows();
            
            // 5. Finally, soft delete the destination itself
            $destinationDeleted = $this->destinationModel->delete($id);
            
            if ($destinationDeleted) {
                $db->transComplete();
                
                if ($db->transStatus() === FALSE) {
                    throw new \Exception('Transaction failed');
                }
                
                // Prepare success message with cascade details
                $cascadeMessages = [];
                if ($cascadeResults['m_loc'] > 0) $cascadeMessages[] = "{$cascadeResults['m_loc']} M-Loc record(s)";
                if ($cascadeResults['v_trip'] > 0) $cascadeMessages[] = "{$cascadeResults['v_trip']} V-Trip record(s)";
                if ($cascadeResults['tmp_mloc'] > 0) $cascadeMessages[] = "{$cascadeResults['tmp_mloc']} temporary M-Loc record(s)";
                if ($cascadeResults['tmp_vtrip'] > 0) $cascadeMessages[] = "{$cascadeResults['tmp_vtrip']} temporary V-Trip record(s)";
                
                $message = "Destinasi '{$destination['destination_name']}' berhasil dihapus";
                if (!empty($cascadeMessages)) {
                    $message .= " beserta " . implode(', ', $cascadeMessages);
                }
                
                log_message('info', "Successfully cascade deleted destination ID {$id} with: " . json_encode($cascadeResults));
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully deleted...');
            } else {
                $db->transRollback();
                throw new \Exception('Failed to delete destination');
            }
            
        } catch (\Exception $e) {
            $db->transRollback();
            // Log the error for debugging
            log_message('error', "Error cascade deleting destination ID {$id}: " . $e->getMessage());
            log_message('error', "Exception trace: " . $e->getTraceAsString());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan saat menghapus destinasi: ' . $e->getMessage());
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function deleteWithoutCascade($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if destination is being used in active (non-soft-deleted) records
        $db = \Config\Database::connect();
        
        // Check m_loc table (only active records)
        $mlocCount = $db->table('m_loc')
                       ->where('destination_id', $id)
                       ->where('deleted_at IS NULL')
                       ->countAllResults();
        
        // Check tmp_mloc table
        $tmpMlocCount = $db->table('tmp_mloc')
                          ->where('destination_id', $id)
                          ->countAllResults();
        
        // Check v_trip table (only active records)
        $vtripCount = $db->table('v_trip')
                        ->where('destination_id', $id)
                        ->where('deleted_at IS NULL')
                        ->countAllResults();
        
        // Check tmp_vtrip table
        $tmpVtripCount = $db->table('tmp_vtrip')
                           ->where('destination_id', $id)
                           ->countAllResults();
        
        $totalUsage = $mlocCount + $tmpMlocCount + $vtripCount + $tmpVtripCount;
        
        if ($totalUsage > 0) {
            $usageDetails = [];
            if ($mlocCount > 0) $usageDetails[] = "M-Loc ({$mlocCount} active records)";
            if ($tmpMlocCount > 0) $usageDetails[] = "M-Loc Temporary ({$tmpMlocCount} records)";
            if ($vtripCount > 0) $usageDetails[] = "V-Trip ({$vtripCount} active records)";
            if ($tmpVtripCount > 0) $usageDetails[] = "V-Trip Temporary ({$tmpVtripCount} records)";
            
            $usageMessage = implode(', ', $usageDetails);
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', "Tidak dapat menghapus destinasi '{$destination['destination_name']}' karena masih digunakan di: {$usageMessage}. Hapus data terkait terlebih dahulu atau gunakan delete cascade.");
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            if ($this->destinationModel->delete($id)) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully deleted...');
            } else {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Gagal menghapus destinasi');
            }
        } catch (\Exception $e) {
            log_message('error', "Error deleting destination ID {$id}: " . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan saat menghapus destinasi: ' . $e->getMessage());
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Destinasi'
        ];

        return view('destinations/create', $data);
    }

    public function edit($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Destinasi tidak ditemukan');
            return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $data = [
            'title' => 'Edit Destinasi',
            'destination' => $destination
        ];

        return view('destinations/edit', $data);
    }

    public function store()
    {
        // Check if user is authenticated
        if (!session()->get('admin_logged_in')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Not authenticated'
                ]);
            }
            return redirect()->to('/auth/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'destination_name' => 'required|min_length[2]|max_length[100]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $errors)
                ]);
            }
            
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', implode(', ', $errors));
            return redirect()->back()->withInput();
        }

        $destinationName = trim($this->request->getPost('destination_name'));

        // Check if name already exists (only non-deleted)
        $existingDestination = $this->destinationModel
            ->where('destination_name', $destinationName)
            ->where('deleted_at', null)
            ->first();

        if ($existingDestination) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Destination already exists'
                ]);
            }
            
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Nama destinasi sudah ada');
            return redirect()->back()->withInput();
        }

        $data = ['destination_name' => $destinationName];
        
        try {
            if ($this->destinationModel->insert($data)) {
                $insertedId = $this->destinationModel->getInsertID();
                
                // Get the inserted destination
                $newDestination = $this->destinationModel->find($insertedId);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Destination added successfully',
                        'destination' => [
                            'id' => $newDestination['id'],
                            'destination_name' => $newDestination['destination_name']
                        ]
                    ]);
                }
                
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully added...');
            } else {
                throw new \Exception('Database insert failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding destination: ' . $e->getMessage());
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add destination'
                ]);
            }
            
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Gagal menambahkan destinasi');
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function clearTmp()
    {
        try {
            $this->tmpDestinationModel->clearAllForCurrentAdmin();
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data successfully deleted...');
        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Gagal membersihkan daftar sementara');
        }

        return redirect()->to('destinations' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function debugDelete($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['error' => 'ID required']);
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            return $this->response->setJSON(['error' => 'Destination not found']);
        }

        // Try direct database update to test soft delete
        $db = \Config\Database::connect();
        
        // Check current state
        $currentState = $db->table('destination')
                          ->where('id', $id)
                          ->get()
                          ->getRowArray();
        
        // Try manual soft delete
        $result = $db->table('destination')
                    ->where('id', $id)
                    ->update(['deleted_at' => date('Y-m-d H:i:s')]);
        
        // Check after update
        $afterState = $db->table('destination')
                        ->where('id', $id)
                        ->get()
                        ->getRowArray();
        
        return $this->response->setJSON([
            'destination_id' => $id,
            'destination_name' => $destination['destination_name'],
            'before_update' => $currentState,
            'update_result' => $result,
            'after_update' => $afterState,
            'model_soft_deletes' => $this->destinationModel->useSoftDeletes,
            'model_deleted_field' => $this->destinationModel->deletedField
        ]);
    }

    public function testSoftDelete($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['error' => 'ID required']);
        }

        $destination = $this->destinationModel->find($id);
        if (!$destination) {
            return $this->response->setJSON(['error' => 'Destination not found']);
        }

        try {
            // Force soft delete without checking foreign keys
            log_message('info', "Testing soft delete for destination ID {$id}: {$destination['destination_name']}");
            
            // Try using the model's delete method
            $modelResult = $this->destinationModel->delete($id);
            
            // Check if it was actually soft deleted
            $afterDelete = $this->destinationModel->withDeleted()->find($id);
            
            return $this->response->setJSON([
                'destination_id' => $id,
                'destination_name' => $destination['destination_name'],
                'model_delete_result' => $modelResult,
                'record_after_delete' => $afterDelete,
                'is_soft_deleted' => ($afterDelete && $afterDelete['deleted_at'] !== null),
                'soft_deletes_enabled' => $this->destinationModel->useSoftDeletes,
                'model_properties' => [
                    'table' => $this->destinationModel->table,
                    'primaryKey' => $this->destinationModel->primaryKey,
                    'deletedField' => $this->destinationModel->deletedField,
                    'useTimestamps' => $this->destinationModel->useTimestamps
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Exception occurred',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function createTestDestination()
    {
        // Create a test destination that can be safely deleted
        $testName = 'Test Destination ' . date('Y-m-d H:i:s');
        
        $data = ['destination_name' => $testName];
        
        if ($this->destinationModel->insert($data)) {
            $insertId = $this->destinationModel->getInsertID();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Test destination created',
                'id' => $insertId,
                'name' => $testName,
                'test_url' => base_url("destinations/testSoftDelete/{$insertId}")
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create test destination'
            ]);
        }
    }

    public function getAll()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        try {
            $destinations = $this->destinationModel->getAllDestinations();
            return $this->response->setJSON([
                'success' => true,
                'data' => $destinations
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting all destinations: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while fetching destinations data'
            ]);
        }
    }
}