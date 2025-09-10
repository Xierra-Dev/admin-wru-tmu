<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeopleModel;
use App\Models\TmpPeopleModel;

class People extends BaseController
{
    protected $peopleModel;
    protected $tmpPeopleModel;

    public function __construct()
    {
        $this->peopleModel = new PeopleModel();
        $this->tmpPeopleModel = new TmpPeopleModel();
    }

    public function index()
    {
        // Clear any potential query cache
        $this->peopleModel->builder()->resetQuery();
        
        $data = [
            'title' => 'Konfigurasi Nama Personil',
            'people' => $this->peopleModel->where('deleted_at', null)
                                         ->orderBy('created_at', 'DESC')
                                         ->paginate(10),
            'pager' => $this->peopleModel->pager,
            'tmp_people' => $this->tmpPeopleModel->getAllForCurrentAdmin()
        ];

        return view('people/index', $data);
    }

    public function addTmp()
    {
        // Hanya terima AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $name = trim($this->request->getPost('name'));

        // Cek duplikasi di tmp_people for current admin
        $existingTmp = $this->tmpPeopleModel->checkDuplicateName($name);
        if ($existingTmp) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nama sudah ada dalam daftar sementara'
            ]);
        }

        // Cek duplikasi di people
        $existingPeople = $this->peopleModel->where('name', $name)
                                          ->where('deleted_at', null)
                                          ->first();
        if ($existingPeople) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Nama sudah ada dalam database utama'
            ]);
        }

        try {
            $data = [
                'name' => $name,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $id = $this->tmpPeopleModel->insert($data);

            if ($id) {
                $insertedData = $this->tmpPeopleModel->find($id);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil ditambahkan ke daftar sementara',
                    'data' => $insertedData
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan data ke daftar sementara'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function removeTmp($id = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }

        if (!$id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID tidak valid'
            ]);
        }

        try {
            // Verify the record belongs to current admin before deleting
            $adminId = session()->get('admin_id');
            $tmpData = $this->tmpPeopleModel->where('admin_id', $adminId)->find($id);
            
            if (!$tmpData) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan atau tidak memiliki akses'
                ]);
            }

            $deleted = $this->tmpPeopleModel->delete($id);

            if ($deleted) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus dari daftar sementara'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan atau gagal dihapus'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function savePeople()
    {
        try {
            $db = \Config\Database::connect();
            $db->transStart();

            $currentName = trim($this->request->getPost('current_name'));
            $savedCount = 0;
            $errors = [];

            // 1. Ambil semua data dari tmp_people untuk admin saat ini
            $tmpData = $this->tmpPeopleModel->getAllForCurrentAdmin();

            // 2. Pindahkan data dari tmp_people ke people
            foreach ($tmpData as $tmp) {
                // Cek duplikasi
                $existing = $this->peopleModel->where('name', $tmp['name'])
                                            ->where('deleted_at', null)
                                            ->first();
                
                if (!$existing) {
                    $peopleData = [
                        'name' => $tmp['name'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->peopleModel->insert($peopleData)) {
                        $savedCount++;
                    } else {
                        $errors[] = "Gagal menyimpan: " . $tmp['name'];
                    }
                }
            }

            // 3. Tambahkan current_name jika ada dan tidak kosong
            if (!empty($currentName)) {
                $existing = $this->peopleModel->where('name', $currentName)
                                            ->where('deleted_at', null)
                                            ->first();
                
                if (!$existing) {
                    $peopleData = [
                        'name' => $currentName,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->peopleModel->insert($peopleData)) {
                        $savedCount++;
                    } else {
                        $errors[] = "Gagal menyimpan: " . $currentName;
                    }
                } else {
                    $errors[] = "Nama '$currentName' sudah ada dalam database";
                }
            }

            // 4. Bersihkan tmp_people jika ada yang tersimpan (hanya untuk admin saat ini)
            if ($savedCount > 0) {
                $this->tmpPeopleModel->clearAllForCurrentAdmin();
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE || !empty($errors)) {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . implode(', ', $errors));
            } else {
                if ($savedCount > 0) {
                    session()->setFlashdata('notification_type', 'success');
                    session()->setFlashdata('notification_message', "Data successfully added...");
                } else {
                    session()->setFlashdata('notification_type', 'warning');
                    session()->setFlashdata('notification_message', 'Tidak ada data yang disimpan');
                }
            }

            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));

        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $name = trim($this->request->getPost('name'));

        // Cek duplikasi
        $existing = $this->peopleModel->where('name', $name)
                                    ->where('deleted_at', null)
                                    ->first();

        if ($existing) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Nama personil sudah ada dalam database');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->peopleModel->insert($data)) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully added...');
            } else {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Gagal menambahkan data personil');
            }

            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));

        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID tidak valid');
            return redirect()->back();
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Data tidak valid: ' . implode(', ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $name = trim($this->request->getPost('name'));

        // Cek apakah data ada
        $existing = $this->peopleModel->where('id', $id)
                                    ->where('deleted_at', null)
                                    ->first();

        if (!$existing) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Data tidak ditemukan');
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Cek duplikasi nama (kecuali untuk data yang sedang diedit)
        $duplicate = $this->peopleModel->where('name', $name)
                                     ->where('id !=', $id)
                                     ->where('deleted_at', null)
                                     ->first();

        if ($duplicate) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Nama personil sudah ada dalam database');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $name,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->peopleModel->update($id, $data)) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully edited...');
            } else {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Gagal memperbarui data personil');
            }

            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));

        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID tidak valid');
            return redirect()->back();
        }

        // Cek apakah data ada
        $existing = $this->peopleModel->where('id', $id)
                                    ->where('deleted_at', null)
                                    ->first();

        if (!$existing) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Data tidak ditemukan');
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            // Debug: Log before delete
            log_message('info', 'Attempting to delete person with ID: ' . $id);
            
            // Check if deleted_at column exists
            $db = \Config\Database::connect();
            $fields = $db->getFieldData('people');
            $hasDeletedAt = false;
            foreach ($fields as $field) {
                if ($field->name === 'deleted_at') {
                    $hasDeletedAt = true;
                    break;
                }
            }
            
            if (!$hasDeletedAt) {
                // If deleted_at column doesn't exist, do hard delete
                log_message('info', 'deleted_at column not found, performing hard delete');
                if ($this->peopleModel->delete($id, true)) { // true for hard delete
                    session()->setFlashdata('notification_type', 'success');
                    session()->setFlashdata('notification_message', 'Data successfully deleted...');
                } else {
                    session()->setFlashdata('notification_type', 'danger');
                    session()->setFlashdata('notification_message', 'Gagal menghapus data personil');
                }
            } else {
                // Soft delete using direct database update to ensure it works
                $data = [
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Use direct database update instead of model update
                $result = $db->table('people')->where('id', $id)->update($data);
                
                // Debug: Log result
                log_message('info', 'Direct database update result: ' . ($result ? 'success' : 'failed'));
                
                if ($result) {
                    // Verify the deletion by checking the record directly from database
                    $deletedRecord = $db->table('people')->where('id', $id)->get()->getRowArray();
                    if ($deletedRecord && $deletedRecord['deleted_at'] !== null) {
                        log_message('info', 'Record successfully soft deleted. deleted_at: ' . $deletedRecord['deleted_at']);
                        session()->setFlashdata('notification_type', 'success');
                        session()->setFlashdata('notification_message', 'Data successfully deleted...');
                    } else {
                        log_message('error', 'Direct update succeeded but deleted_at is still null');
                        session()->setFlashdata('notification_type', 'danger');
                        session()->setFlashdata('notification_message', 'Gagal menghapus data personil - verifikasi gagal');
                    }
                } else {
                    session()->setFlashdata('notification_type', 'danger');
                    session()->setFlashdata('notification_message', 'Gagal menghapus data personil');
                }
            }

            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));

        } catch (\Exception $e) {
            log_message('error', 'Delete operation exception: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    // Alternative delete method with simplified approach
    public function deleteSimple($id = null)
    {
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'ID tidak valid');
            return redirect()->back();
        }

        try {
            $db = \Config\Database::connect();
            
            // Check if record exists
            $existing = $db->table('people')
                          ->where('id', $id)
                          ->where('deleted_at IS NULL')
                          ->get()
                          ->getRowArray();
            
            if (!$existing) {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Data tidak ditemukan');
                return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }
            
            // Simple direct update
            $result = $db->table('people')
                        ->where('id', $id)
                        ->update([
                            'deleted_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            
            if ($result) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully deleted...');
            } else {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'Gagal menghapus data personil');
            }
            
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            
        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->to('people' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }
    }

    public function debug()
    {
        $db = \Config\Database::connect();
        
        // Check table structure
        $fields = $db->getFieldData('people');
        
        echo "<h2>Table Structure:</h2>";
        echo "<pre>";
        print_r($fields);
        echo "</pre>";
        
        // Check all records including deleted
        $allRecords = $this->peopleModel->withDeleted()->findAll();
        
        echo "<h2>All Records (including deleted):</h2>";
        echo "<pre>";
        print_r($allRecords);
        echo "</pre>";
        
        // Check only active records
        $activeRecords = $this->peopleModel->where('deleted_at', null)->findAll();
        
        echo "<h2>Active Records Only:</h2>";
        echo "<pre>";
        print_r($activeRecords);
        echo "</pre>";
        
        die();
    }

    public function clearTmp()
    {
        try {
            $this->tmpPeopleModel->clearAllForCurrentAdmin();
            session()->setFlashdata('notification_type', 'success');
            session()->setFlashdata('notification_message', 'Data sementara berhasil dibersihkan');
        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Gagal membersihkan data sementara: ' . $e->getMessage());
        }

        return redirect()->to('people' . ($this->request->getPost('config_mode') ? '?config=1' : ''));
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
        $personName = trim($input['name'] ?? '');

        // Validate input
        if (empty($personName)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Person name is required'
            ]);
        }

        if (strlen($personName) < 2 || strlen($personName) > 100) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Person name must be between 2 and 100 characters'
            ]);
        }

        // Check for duplicates
        $existing = $this->peopleModel->where('name', $personName)
                                    ->where('deleted_at', null)
                                    ->first();

        if ($existing) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Person name already exists'
            ]);
        }

        $data = [
            'name' => $personName
        ];

        try {
            if ($this->peopleModel->insert($data)) {
                $insertedId = $this->peopleModel->getInsertID();
                
                // Get the inserted person
                $newPerson = $this->peopleModel->find($insertedId);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Person added successfully',
                    'person' => [
                        'id' => $newPerson['id'],
                        'name' => $newPerson['name']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to add person'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error adding quick person: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while adding the person'
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
            $people = $this->peopleModel->getAllPeople();
            return $this->response->setJSON([
                'success' => true,
                'data' => $people
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error getting all people: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while fetching people data'
            ]);
        }
    }
}