<?php
// app/Controllers/MLoc.php
namespace App\Controllers;

use App\Models\MLocModel;
use App\Models\TmpMLocModel;
use App\Models\PeopleModel;
use App\Models\DestinationModel;

class MLoc extends BaseController
{
    protected $mlocModel;
    protected $tmpMlocModel;
    protected $peopleModel;
    protected $destinationModel;

    public function __construct()
    {
        $this->mlocModel = new MLocModel();
        $this->tmpMlocModel = new TmpMLocModel();
        $this->peopleModel = new PeopleModel();
        $this->destinationModel = new DestinationModel();
    }
    
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Clean up old temporary data (older than 24 hours)
        try {
            $this->tmpMlocModel->cleanupOldData();
        } catch (\Exception $e) {
            // Log error but don't interrupt the page load
            log_message('error', 'Failed to cleanup old tmp_mloc data: ' . $e->getMessage());
        }

        // Ambil semua data mloc yang belum dimulai (leave_date >= today)
        $today = date('Y-m-d');
        $allMlocs = $this->mlocModel
                        ->select('m_loc.*, people.name as people_name, destination.destination_name')
                        ->join('people', 'people.id = m_loc.people_id')
                        ->join('destination', 'destination.id = m_loc.destination_id')
                        ->where('m_loc.deleted_at', null)
                        ->where('people.deleted_at', null)
                        ->where('destination.deleted_at', null)
                        ->where('m_loc.leave_date >=', $today)
                        ->orderBy('people.name', 'ASC')
                        ->findAll();
        
        // Expand each schedule into daily cards
        $expandedMlocs = [];
        foreach ($allMlocs as $mloc) {
            $dailyCards = $this->generateDailyCards($mloc);
            $expandedMlocs = array_merge($expandedMlocs, $dailyCards);
        }
        
        // Kelompokkan data berdasarkan nama personil
        $groupedMlocs = [];
        foreach ($expandedMlocs as $mloc) {
            $peopleName = $mloc['people_name'];
            if (!isset($groupedMlocs[$peopleName])) {
                $groupedMlocs[$peopleName] = [];
            }
            $groupedMlocs[$peopleName][] = $mloc;
        }

        $data = [
            'title' => 'M-Loc',
            'groupedMlocs' => $groupedMlocs,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
        ];

        return view('mloc/index', $data);
    }

    /**
     * Generate daily schedule cards based on date range
     */
    private function generateDailyCards($mloc)
    {
        $dailyCards = [];
        $startDate = new \DateTime($mloc['leave_date']);
        $endDate = new \DateTime($mloc['return_date']);
        
        // If same day, create one card
        if ($startDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
            $dailyCards[] = $mloc;
            return $dailyCards;
        }
        
        // Create cards for each day in the range
        $currentDate = clone $startDate;
        $dayNumber = 1;
        
        while ($currentDate <= $endDate) {
            $dayCard = $mloc;
            $dayCard['leave_date'] = $currentDate->format('Y-m-d H:i:s');
            $dayCard['day_number'] = $dayNumber;
            $dayCard['total_days'] = $startDate->diff($endDate)->days + 1;
            $dayCard['original_id'] = $mloc['id']; // Keep original ID for reference
            $dayCard['daily_card_id'] = $mloc['id'] . '_day_' . $dayNumber; // Unique ID for each day card
            
            // Set display title for the day
            if ($dayNumber === 1) {
                $dayCard['day_title'] = 'Day ' . $dayNumber . ' (Departure)';
            } elseif ($currentDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
                $dayCard['day_title'] = 'Day ' . $dayNumber . ' (Return)';
            } else {
                $dayCard['day_title'] = 'Day ' . $dayNumber;
            }
            
            $dailyCards[] = $dayCard;
            $currentDate->add(new \DateInterval('P1D'));
            $dayNumber++;
        }
        
        return $dailyCards;
    }

    /**
     * Delete all schedules for a specific person
     */
    public function deleteAllByPerson()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        $peopleName = $this->request->getPost('people_name');
        
        if (empty($peopleName)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Person name is required.'
            ]);
        }

        try {
            // Find all schedules for this person
            $person = $this->peopleModel->where('name', $peopleName)->first();
            
            if (!$person) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Person not found.'
                ]);
            }

            $schedules = $this->mlocModel->where('people_id', $person['id'])
                                       ->where('deleted_at', null)
                                       ->findAll();
            
            if (empty($schedules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No schedules found to delete.'
                ]);
            }
            
            $deletedCount = 0;
            foreach ($schedules as $schedule) {
                if ($this->mlocModel->delete($schedule['id'])) {
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => "Successfully deleted {$deletedCount} schedule(s) for {$peopleName}."
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No schedules were deleted.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Delete all schedules with flash message for a specific person
     */
    public function deleteAllByPersonWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'Not authenticated.');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $peopleName = $this->request->getPost('people_name');
        
        if (empty($peopleName)) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'Person name is required.');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            // Find all schedules for this person
            $person = $this->peopleModel->where('name', $peopleName)->first();
            
            if (!$person) {
                session()->setFlashdata('notification_type', 'error');
                session()->setFlashdata('notification_message', 'Person not found.');
                return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }

            $schedules = $this->mlocModel->where('people_id', $person['id'])
                                       ->where('deleted_at', null)
                                       ->findAll();
            
            if (empty($schedules)) {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'No schedules found to delete.');
                return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }
            
            $deletedCount = 0;
            foreach ($schedules as $schedule) {
                if ($this->mlocModel->delete($schedule['id'])) {
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', "Successfully deleted {$deletedCount} schedule(s) for {$peopleName}.");
            } else {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'No schedules were deleted.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'An error occurred: ' . $e->getMessage());
        }

        return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    public function create()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Tambah M-Loc',
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'tmp_mlocs' => $this->tmpMlocModel->getAllTmpMLocWithDetails()
        ];

        return view('mloc/create', $data);
    }

    public function addToTemp()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'request_by' => 'required|min_length[3]|max_length[255]',
            'leave_date' => 'required|valid_date',
            'return_date' => 'required|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Validation failed', 'errors' => $validation->getErrors()]);
        }

        $leaveDate = $this->request->getPost('leave_date');
        $returnDate = $this->request->getPost('return_date');

        if ($leaveDate >= $returnDate) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Tanggal kembali harus setelah tanggal pergi!']);
        }

        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('request_by'),
            'leave_date' => $leaveDate,
            'return_date' => $returnDate,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->tmpMlocModel->insert($data)) {
            return $this->response->setJSON(['message' => 'Data berhasil ditambahkan ke daftar sementara!']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menambahkan data!']);
        }
    }

    public function editTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $tmpMloc = $this->tmpMlocModel->find($id);
        if (!$tmpMloc) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Sementara',
            'tmpMloc' => $tmpMloc,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations()
        ];

        return view('mloc/edit_temp', $data);
    }

    public function updateTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'requestBy' => 'required|min_length[3]|max_length[255]',
            'leaveDate' => 'required|valid_date',
            'returnDate' => 'required|valid_date'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Validation failed', 'errors' => $validation->getErrors()]);
        }

        $leaveDate = $this->request->getPost('leaveDate');
        $returnDate = $this->request->getPost('returnDate');

        if ($leaveDate >= $returnDate) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Tanggal kembali harus setelah tanggal pergi!']);
        }

        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('requestBy'),
            'leave_date' => $leaveDate,
            'return_date' => $returnDate
        ];

        if ($this->tmpMlocModel->update($id, $data)) {
            return $this->response->setJSON(['message' => 'Data sementara berhasil diupdate!']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal update data!']);
        }
    }

    public function deleteTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        if ($this->tmpMlocModel->delete($id)) {
            return $this->response->setJSON(['message' => 'Data sementara berhasil dihapus!']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menghapus data!']);
        }
    }

    public function saveAll()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        $tmpData = $this->tmpMlocModel->findAll();
        if (empty($tmpData)) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Tidak ada data untuk disimpan!']);
        }

        if ($this->tmpMlocModel->moveToMainTable()) {
            return $this->response->setJSON(['message' => 'Semua data berhasil disimpan!']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menyimpan data!']);
        }
    }

    public function clearTemp()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        if ($this->tmpMlocModel->clearAll()) {
            return $this->response->setJSON(['message' => 'Daftar sementara berhasil dibersihkan!']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal membersihkan daftar!']);
        }
    }

    public function store()
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    // Validasi input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'people_id' => 'required|integer',
        'destination_id' => 'required|integer',
        'leaving_date' => 'required|valid_date',
        'return_date' => 'required|valid_date',
        'request_by' => 'permit_empty|max_length[255]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validation->getErrors()
        ]);
    }

    $leavingDate = $this->request->getPost('leaving_date');
    $returnDate = $this->request->getPost('return_date');

    // Validasi tanggal
    if (strtotime($leavingDate) > strtotime($returnDate)) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Return date must be after leaving date!'
        ]);
    }

    // Check for schedule conflicts (unless force save is specified)
    $forceSave = $this->request->getPost('force_save');
    if (!$forceSave) {
        $conflictCheck = $this->checkScheduleConflict(
            $this->request->getPost('people_id'),
            $leavingDate,
            $returnDate,
            null, // excludeId (null for new records)
            $this->request->getPost('destination_id') // destinationId
        );

        if ($conflictCheck['hasConflict']) {
            return $this->response->setStatusCode(409)->setJSON([
                'success' => false,
                'message' => 'Schedule conflict detected',
                'conflict' => $conflictCheck
            ]);
        }
    }

    // Prepare data
    $data = [
        'people_id' => $this->request->getPost('people_id'),
        'destination_id' => $this->request->getPost('destination_id'),
        'request_by' => $this->request->getPost('request_by') ?: '-',
        'leave_date' => $leavingDate,
        'return_date' => $returnDate,
        'letter' => $this->request->getPost('letter') ? 1 : 0,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        if ($this->mlocModel->insert($data)) {
            $message = $forceSave ? 'Data successfully added!' : 'M-Loc data successfully saved!';
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'data' => $data
            ]);
        } else {
            throw new \Exception('Database insert failed');
        }
    } catch (\Exception $e) {
        log_message('error', 'MLoc store error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to save data. Please try again.'
        ]);
    }
}

/**
 * Store multiple M-Loc data
 */
public function storeMultiple()
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    // Get JSON input
    $input = $this->request->getJSON(true);
    
    if (!isset($input['data']) || !is_array($input['data']) || empty($input['data'])) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'No data provided for multiple insert'
        ]);
    }

    $dataToInsert = [];
    $conflicts = [];
    
    // Check if force_save is enabled to skip conflict checking
    $forceSave = $input['force_save'] ?? false;

    foreach ($input['data'] as $index => $item) {
        // Validate each item
        if (!isset($item['people_id']) || !isset($item['destination_id']) || 
            !isset($item['leaving_date']) || !isset($item['return_date'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => "Invalid data at index {$index}. Required fields missing."
            ]);
        }

        // Date validation
        if (strtotime($item['leaving_date']) > strtotime($item['return_date'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => "Invalid date range at index {$index}. Return date must be on or after leaving date."
            ]);
        }

        // Check for conflicts only if force_save is not enabled
        if (!$forceSave) {
            $conflictCheck = $this->checkScheduleConflict(
                $item['people_id'],
                $item['leaving_date'],
                $item['return_date'],
                null, // excludeId (null for new records)
                $item['destination_id'] // destinationId
            );

            if ($conflictCheck['hasConflict']) {
                $conflicts[] = [
                    'index' => $index,
                    'conflict' => $conflictCheck
                ];
            }
        }

        // Prepare data
        $dataToInsert[] = [
            'people_id' => $item['people_id'],
            'destination_id' => $item['destination_id'],
            'request_by' => $item['request_by'] ?? '-',
            'leave_date' => $item['leaving_date'],
            'return_date' => $item['return_date'],
            'letter' => ($item['letter'] === '1') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
    }

    // If there are conflicts and force_save is not enabled, return them for user decision
    if (!$forceSave && !empty($conflicts)) {
        return $this->response->setStatusCode(409)->setJSON([
            'success' => false,
            'message' => 'Schedule conflicts detected',
            'conflicts' => $conflicts
        ]);
    }

    try {
        // Use transaction for multiple inserts
        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($dataToInsert as $data) {
            if (!$this->mlocModel->insert($data)) {
                $db->transRollback();
                throw new \Exception('Failed to insert data');
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new \Exception('Transaction failed');
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $forceSave ? 'Data successfully added despite conflicts!' : 'Data successfully added',
            'inserted_count' => count($dataToInsert)
        ]);

    } catch (\Exception $e) {
        log_message('error', 'MLoc storeMultiple error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to save multiple data. Please try again.'
        ]);
    }
}

/**
 * Update M-Loc data (modified to work with new form)
 */
public function update()
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    $id = $this->request->getPost('mloc_id');
    
    if (!$id) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'M-Loc ID is required'
        ]);
    }

    // Check if record exists
    $existingData = $this->mlocModel->find($id);
    if (!$existingData) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'M-Loc data not found'
        ]);
    }

    // Validasi input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'people_id' => 'required|integer',
        'destination_id' => 'required|integer',
        'leaving_date' => 'required|valid_date',
        'return_date' => 'required|valid_date',
        'request_by' => 'permit_empty|max_length[255]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validation->getErrors()
        ]);
    }

    $leavingDate = $this->request->getPost('leaving_date');
    $returnDate = $this->request->getPost('return_date');

    // Validasi tanggal
    if (strtotime($leavingDate) > strtotime($returnDate)) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Return date must be after leaving date!'
        ]);
    }

    // Check for schedule conflicts (exclude current record) unless force save is specified
    $forceSave = $this->request->getPost('force_save');
    if (!$forceSave) {
        $conflictCheck = $this->checkScheduleConflict(
            $this->request->getPost('people_id'),
            $leavingDate,
            $returnDate,
            $id, // exclude current record from conflict check
            $this->request->getPost('destination_id') // destinationId
        );

        if ($conflictCheck['hasConflict']) {
            return $this->response->setStatusCode(409)->setJSON([
                'success' => false,
                'message' => 'Schedule conflict detected',
                'conflict' => $conflictCheck
            ]);
        }
    }

    // Prepare update data
    $data = [
        'people_id' => $this->request->getPost('people_id'),
        'destination_id' => $this->request->getPost('destination_id'),
        'request_by' => $this->request->getPost('request_by') ?: '-',
        'leave_date' => $leavingDate,
        'return_date' => $returnDate,
        'letter' => $this->request->getPost('letter') ? 1 : 0,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        if ($this->mlocModel->update($id, $data)) {
            $message = $forceSave ? 'Data successfully updated!' : 'M-Loc data successfully updated!';
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'data' => $data
            ]);
        } else {
            throw new \Exception('Database update failed');
        }
    } catch (\Exception $e) {
        log_message('error', 'MLoc update error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to update data. Please try again.'
        ]);
    }
}

/**
 * Delete M-Loc data (modified to accept JSON input)
 */
public function delete()
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    // Get JSON input
    $input = $this->request->getJSON(true);
    $id = $input['id'] ?? null;

    // Log the received data for debugging
    log_message('info', 'Delete request received with data: ' . json_encode($input));

    if (!$id) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'M-Loc ID is required'
        ]);
    }

    // Check if record exists
    $existingData = $this->mlocModel->find($id);
    if (!$existingData) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'M-Loc data not found'
        ]);
    }

    try {
        log_message('info', 'Attempting to delete M-Loc with ID: ' . $id);
        
        // Try model delete first
        if ($this->mlocModel->delete($id)) {
            log_message('info', 'M-Loc deleted successfully: ' . $id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'M-Loc data successfully deleted!'
            ]);
        } else {
            // If model delete fails, try direct database update
            log_message('info', 'Model delete failed, trying direct database update for ID: ' . $id);
            $db = \Config\Database::connect();
            $result = $db->table('m_loc')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
            
            if ($result) {
                log_message('info', 'Direct database delete successful for ID: ' . $id);
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'M-Loc data successfully deleted!'
                ]);
            } else {
                throw new \Exception('Both model and direct database delete failed');
            }
        }
    } catch (\Exception $e) {
        log_message('error', 'MLoc delete error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to delete data. Please try again. Error: ' . $e->getMessage()
        ]);
    }
}

/**
 * Simple delete method that bypasses model complications
 */
public function deleteSimple($id = null)
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    // Get ID from URL parameter if not provided in JSON
    if (!$id) {
        $input = $this->request->getJSON(true);
        $id = $input['id'] ?? null;
    }

    if (!$id) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'M-Loc ID is required'
        ]);
    }

    try {
        $db = \Config\Database::connect();
        
        // Check if record exists
        $record = $db->table('m_loc')->where('id', $id)->get()->getRowArray();
        if (!$record) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'M-Loc data not found'
            ]);
        }

        // Perform direct database soft delete
        $result = $db->table('m_loc')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        
        if ($result) {
            log_message('info', 'M-Loc simple delete successful for ID: ' . $id);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'M-Loc data successfully deleted!'
            ]);
        } else {
            throw new \Exception('Database update failed');
        }
    } catch (\Exception $e) {
        log_message('error', 'M-Loc simple delete error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to delete data. Error: ' . $e->getMessage()
        ]);
    }
}

/**
 * Check for schedule conflicts (enhanced to include destination)
 */
private function checkScheduleConflict($peopleId, $leaveDate, $returnDate, $excludeId = null, $destinationId = null)
{
    $query = $this->mlocModel->where('people_id', $peopleId)
                            ->groupStart()
                                ->where('leave_date <=', $returnDate)
                                ->where('return_date >=', $leaveDate)
                            ->groupEnd();
    
    // If destination is specified, also check for same destination conflicts
    if ($destinationId) {
        $query->where('destination_id', $destinationId);
    }
    
    // Exclude current record if updating
    if ($excludeId) {
        $query->where('id !=', $excludeId);
    }

    $conflicts = $query->findAll();

    return [
        'hasConflict' => !empty($conflicts),
        'conflicts' => $conflicts,
        'count' => count($conflicts)
    ];
}

/**
 * AJAX endpoint to check for schedule conflicts
 */
public function checkConflict()
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    // Get JSON input
    $input = $this->request->getJSON(true);
    
    if (!$input) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Invalid JSON input'
        ]);
    }

    $peopleId = $input['people_id'] ?? null;
    $leavingDate = $input['leaving_date'] ?? null;
    $returnDate = $input['return_date'] ?? null;
    $destinationId = $input['destination_id'] ?? null;
    $excludeId = $input['exclude_id'] ?? null;

    if (!$peopleId || !$leavingDate || !$returnDate) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'Missing required parameters'
        ]);
    }

    $conflictCheck = $this->checkScheduleConflict($peopleId, $leavingDate, $returnDate, $excludeId, $destinationId);

    return $this->response->setJSON([
        'success' => true,
        'hasConflict' => $conflictCheck['hasConflict'],
        'conflicts' => $conflictCheck['conflicts'],
        'count' => $conflictCheck['count']
    ]);
}

/**
 * Get M-Loc data for editing (AJAX endpoint)
 */
public function getData($id)
{
    if (!session()->get('admin_logged_in')) {
        return $this->response->setStatusCode(403)->setJSON([
            'success' => false,
            'message' => 'Unauthorized access'
        ]);
    }

    $data = $this->mlocModel
                 ->select('m_loc.*, people.name as people_name, destination.destination_name')
                 ->join('people', 'people.id = m_loc.people_id')
                 ->join('destination', 'destination.id = m_loc.destination_id')
                 ->find($id);

    if (!$data) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'Data not found'
        ]);
    }

    return $this->response->setJSON([
        'success' => true,
        'data' => $data
    ]);
}

    public function edit($id)
    {
        // Pengecekan otorisasi
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON(['message' => 'Unauthorized']);
        }

        $mloc = $this->mlocModel->find($id);

        if (!$mloc) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($mloc);
    }

    /**
     * Store M-Loc data with flash message (for page refresh scenarios)
     */
    public function storeWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'request_by' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Validation failed: ' . implode(', ', $validation->getErrors()));
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        // Validasi tanggal
        if (strtotime($leavingDate) > strtotime($returnDate)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Return date must be after leaving date!');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check for schedule conflicts (unless force save is specified)
        $forceSave = $this->request->getPost('force_save');
        if (!$forceSave) {
            $conflictCheck = $this->checkScheduleConflict(
                $this->request->getPost('people_id'),
                $leavingDate,
                $returnDate,
                null, // excludeId (null for new records)
                $this->request->getPost('destination_id') // destinationId
            );

            if ($conflictCheck['hasConflict']) {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'Schedule conflict detected. Please check existing schedules.');
                return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }
        }

        // Prepare data
        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('request_by') ?: '-',
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'letter' => $this->request->getPost('letter') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->mlocModel->insert($data)) {
                $message = $forceSave ? 'Data saved despite schedule conflict!' : 'Data successfully added...';
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', $message);
            } else {
                throw new \Exception('Database insert failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc store error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Data failed to add...');
        }

        return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Update M-Loc data with flash message (for page refresh scenarios)
     */
    public function updateWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $id = $this->request->getPost('mloc_id');
        
        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'M-Loc ID is required');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check if record exists
        $existingData = $this->mlocModel->find($id);
        if (!$existingData) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'M-Loc data not found');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'request_by' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Validation failed: ' . implode(', ', $validation->getErrors()));
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        // Validasi tanggal
        if (strtotime($leavingDate) > strtotime($returnDate)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Return date must be after leaving date!');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check for schedule conflicts (exclude current record) unless force save is specified
        $forceSave = $this->request->getPost('force_save');
        if (!$forceSave) {
            $conflictCheck = $this->checkScheduleConflict(
                $this->request->getPost('people_id'),
                $leavingDate,
                $returnDate,
                $id, // exclude current record from conflict check
                $this->request->getPost('destination_id') // destinationId
            );

            if ($conflictCheck['hasConflict']) {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'Schedule conflict detected. Please check existing schedules.');
                return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }
        }

        // Prepare update data
        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('request_by') ?: '-',
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'letter' => $this->request->getPost('letter') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->mlocModel->update($id, $data)) {
                $message = $forceSave ? 'Data successfully edited despite schedule conflict!' : 'Data successfully edited...';
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', $message);
            } else {
                throw new \Exception('Database update failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc update error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to update data. Please try again.');
        }

        return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Delete M-Loc data with flash message (for page refresh scenarios)
     */
    public function deleteWithFlash($id = null)
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Get ID from URL parameter or POST data
        if (!$id) {
            $id = $this->request->getPost('mloc_id');
        }

        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'M-Loc ID is required');
            return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            // Check if record exists
            $existingData = $this->mlocModel->find($id);
            if (!$existingData) {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'M-Loc data not found');
                return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }

            log_message('info', 'Attempting to delete M-Loc with ID: ' . $id);
            
            // Try model delete first
            if ($this->mlocModel->delete($id)) {
                log_message('info', 'M-Loc deleted successfully: ' . $id);
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully deleted...');
            } else {
                // If model delete fails, try direct database update
                log_message('info', 'Model delete failed, trying direct database update for ID: ' . $id);
                $db = \Config\Database::connect();
                $result = $db->table('m_loc')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                
                if ($result) {
                    log_message('info', 'Direct database delete successful for ID: ' . $id);
                    session()->setFlashdata('notification_type', 'success');
                    session()->setFlashdata('notification_message', 'Data successfully deleted...');
                } else {
                    throw new \Exception('Both model and direct database delete failed');
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc delete error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to delete data. Please try again.');
        }

        return redirect()->to('mloc' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Get temporary data for multiple data mode
     */
    public function getTempData()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        try {
            $tmpData = $this->tmpMlocModel->getAllTmpMLocWithDetails();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $tmpData
            ]);
        } catch (\Exception $e) {
            log_message('error', 'MLoc getTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to fetch temporary data'
            ]);
        }
    }

    /**
     * Add to temporary table for multiple data mode
     */
    public function addToTempData()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'request_by' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        // Date validation
        if (strtotime($leavingDate) > strtotime($returnDate)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Return date must be on or after leaving date'
            ]);
        }

        // Prepare data for temporary table
        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('request_by') ?: '-',
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'letter' => $this->request->getPost('letter') ? 1 : 0,
            'admin_id' => session()->get('admin_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->tmpMlocModel->insert($data)) {
                // Get the newly inserted data with details
                $insertId = $this->tmpMlocModel->getInsertID();
                $insertedData = $this->tmpMlocModel
                    ->select('tmp_mloc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = tmp_mloc.people_id')
                    ->join('destination', 'destination.id = tmp_mloc.destination_id')
                    ->find($insertId);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data successfully added to temporary list',
                    'data' => $insertedData
                ]);
            } else {
                throw new \Exception('Failed to insert data to temporary table');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc addToTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to add data to temporary list'
            ]);
        }
    }

    /**
     * Edit temporary data
     */
    public function editTempData($id)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        $tmpData = $this->tmpMlocModel->where('admin_id', session()->get('admin_id'))->find($id);
        if (!$tmpData) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Temporary data not found'
            ]);
        }

        // Validation
        $validation = \Config\Services::validation();
        $validation->setRules([
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date',
            'return_date' => 'required|valid_date',
            'request_by' => 'permit_empty|max_length[255]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ]);
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        // Date validation
        if (strtotime($leavingDate) > strtotime($returnDate)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Return date must be on or after leaving date'
            ]);
        }

        // Prepare update data
        $data = [
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'request_by' => $this->request->getPost('request_by') ?: '-',
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'letter' => $this->request->getPost('letter') ? 1 : 0
        ];

        try {
            if ($this->tmpMlocModel->update($id, $data)) {
                // Get the updated data with details
                $updatedData = $this->tmpMlocModel
                    ->select('tmp_mloc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = tmp_mloc.people_id')
                    ->join('destination', 'destination.id = tmp_mloc.destination_id')
                    ->find($id);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Temporary data successfully updated',
                    'data' => $updatedData
                ]);
            } else {
                throw new \Exception('Failed to update temporary data');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc editTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to update temporary data'
            ]);
        }
    }

    /**
     * Delete temporary data
     */
    public function deleteTempData($id)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        $tmpData = $this->tmpMlocModel->where('admin_id', session()->get('admin_id'))->find($id);
        if (!$tmpData) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Temporary data not found'
            ]);
        }

        try {
            if ($this->tmpMlocModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Temporary data successfully deleted'
                ]);
            } else {
                throw new \Exception('Failed to delete temporary data');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc deleteTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to delete temporary data'
            ]);
        }
    }

    /**
     * Save all temporary data to main table
     */
    public function saveAllTempData()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        try {
            // Check if there's any temporary data
            $tmpData = $this->tmpMlocModel->where('admin_id', session()->get('admin_id'))->findAll();
            if (empty($tmpData)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'No temporary data to save'
                ]);
            }

            // Move all data from temporary to main table
            if ($this->tmpMlocModel->moveToMainTable()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'All data successfully saved!',
                    'saved_count' => count($tmpData)
                ]);
            } else {
                throw new \Exception('Failed to move data to main table');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc saveAllTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to save all data. Please try again.'
            ]);
        }
    }

    /**
     * Clear all temporary data without saving
     */
    public function clearAllTempData()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        try {
            if ($this->tmpMlocModel->clearAll()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'All temporary data cleared'
                ]);
            } else {
                throw new \Exception('Failed to clear temporary data');
            }
        } catch (\Exception $e) {
            log_message('error', 'MLoc clearAllTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to clear temporary data'
            ]);
        }
    }

}
