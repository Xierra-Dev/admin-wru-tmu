<?php

namespace App\Controllers;

use App\Models\VtripModel;
use App\Models\TmpVtripModel;
use App\Models\PeopleModel;
use App\Models\DestinationModel;
use App\Models\VehicleModel;

class Vtrip extends BaseController
{
    protected $vtripModel;
    protected $tmpVtripModel;
    protected $peopleModel;
    protected $destinationModel;
    protected $vehicleModel;

    public function __construct()
    {
        $this->vtripModel = new VtripModel();
        $this->tmpVtripModel = new TmpVtripModel();
        $this->peopleModel = new PeopleModel();
        $this->destinationModel = new DestinationModel();
        $this->vehicleModel = new VehicleModel();
    }

    /**
     * Menampilkan daftar V-trip yang sudah dikonfirmasi.
     */
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Clean up old temporary data (older than 24 hours)
        try {
            $this->tmpVtripModel->cleanupOldData();
        } catch (\Exception $e) {
            // Log error but don't interrupt the page load
            log_message('error', 'Failed to cleanup old tmp_vtrip data: ' . $e->getMessage());
        }

        // Ambil data Vtrip dengan join (hanya yang belum dimulai)
        $today = date('Y-m-d');
        $vtrips = $this->vtripModel
            ->select('v_trip.*, vehicle.vehicle_name, vehicle.number_plate, people.name as people_name, destination.destination_name')
            ->join('vehicle', 'vehicle.id = v_trip.vehicle_id', 'left')
            ->join('people', 'people.id = v_trip.people_id', 'left')
            ->join('destination', 'destination.id = v_trip.destination_id', 'left')
            ->where('v_trip.deleted_at', null)
            ->where('vehicle.deleted_at', null)
            ->where('people.deleted_at', null)
            ->where('destination.deleted_at', null)
            ->where('v_trip.leave_date >=', $today)
            ->orderBy('vehicle.vehicle_name', 'ASC')
            ->orderBy('vehicle.number_plate', 'ASC')
            ->orderBy('v_trip.leave_date', 'ASC')
            ->findAll();

        // Expand each trip into daily cards
        $expandedVtrips = [];
        foreach ($vtrips as $vtrip) {
            $dailyCards = $this->generateDailyCards($vtrip);
            $expandedVtrips = array_merge($expandedVtrips, $dailyCards);
        }

        // Group V-trips by vehicle (vehicle_name + number_plate)
        $groupedVtrips = [];
        foreach ($expandedVtrips as $vtrip) {
            $vehicleKey = ($vtrip['vehicle_name'] ?? 'Unknown') . ' - ' . ($vtrip['number_plate'] ?? 'Unknown');
            if (!isset($groupedVtrips[$vehicleKey])) {
                $groupedVtrips[$vehicleKey] = [];
            }
            $groupedVtrips[$vehicleKey][] = $vtrip;
        }

        $data = [
            'title' => 'Data V-Trip',
            'vtrips' => $expandedVtrips,
            'groupedVtrips' => $groupedVtrips,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'vehicles' => $this->vehicleModel->getAllVehicles(),
        ];

        return view('vtrip/index', $data);
    }

    /**
     * Generate daily trip cards based on date range
     */
    private function generateDailyCards($vtrip)
    {
        $dailyCards = [];
        $startDate = new \DateTime($vtrip['leave_date']);
        $endDate = new \DateTime($vtrip['return_date']);
        
        // If same day, create one card
        if ($startDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
            $dailyCards[] = $vtrip;
            return $dailyCards;
        }
        
        // Create cards for each day in the range
        $currentDate = clone $startDate;
        $dayNumber = 1;
        
        while ($currentDate <= $endDate) {
            $dayCard = $vtrip;
            $dayCard['leave_date'] = $currentDate->format('Y-m-d H:i:s');
            $dayCard['day_number'] = $dayNumber;
            $dayCard['total_days'] = $startDate->diff($endDate)->days + 1;
            $dayCard['original_id'] = $vtrip['id']; // Keep original ID for reference
            $dayCard['daily_card_id'] = $vtrip['id'] . '_day_' . $dayNumber; // Unique ID for each day card
            
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
     * Store single V-trip data
     */
    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date[Y-m-d\TH:i]',
            'return_date' => 'required|valid_date[Y-m-d\TH:i]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed.', 
                'errors' => $validation->getErrors()
            ]);
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        if ($leavingDate >= $returnDate) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Return date & time must be after leaving date & time!'
            ]);
        }

        // Check for conflicts unless force_save is set
        if (!$this->request->getPost('force_save')) {
            $conflicts = $this->checkScheduleConflicts(
                $this->request->getPost('people_id'),
                $this->request->getPost('vehicle_id'),
                $leavingDate,
                $returnDate
            );
            
            if (!empty($conflicts)) {
                return $this->response->setStatusCode(409)->setJSON([
                    'success' => false,
                    'message' => 'Schedule conflict detected',
                    'conflicts' => $conflicts
                ]);
            }
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->vtripModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'V-Trip data successfully saved!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Failed to save V-Trip data!'
            ]);
        }
    }

    /**
     * Store multiple V-trip data
     */
    public function storeMultiple()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        $input = $this->request->getJSON(true);
        $dataArray = $input['data'] ?? [];

        if (empty($dataArray)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'No data provided'
            ]);
        }

        $successCount = 0;
        $errors = [];

        foreach ($dataArray as $data) {
            // Validate each data entry
            if (empty($data['people_id']) || empty($data['vehicle_id']) || 
                empty($data['leaving_date']) || empty($data['return_date']) || 
                empty($data['destination_id'])) {
                $errors[] = "Invalid data for {$data['people_name']}";
                continue;
            }

            if ($data['leaving_date'] >= $data['return_date']) {
                $errors[] = "Invalid date range for {$data['people_name']}";
                continue;
            }

            $insertData = [
                'vehicle_id' => $data['vehicle_id'],
                'people_id' => $data['people_id'],
                'destination_id' => $data['destination_id'],
                'leave_date' => $data['leaving_date'],
                'return_date' => $data['return_date'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->vtripModel->insert($insertData)) {
                $successCount++;
            } else {
                $errors[] = "Failed to save data for {$data['people_name']}";
            }
        }

        if ($successCount > 0) {
            $message = "Data successfully added!";
            if (!empty($errors)) {
                $message .= " Some errors occurred: " . implode(', ', $errors);
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Failed to save V-Trip data: ' . implode(', ', $errors)
            ]);
        }
    }

    /**
     * Store V-Trip data with flash message (for page refresh scenarios)
     */
    public function storeWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Validation failed: ' . implode(', ', $validation->getErrors()));
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Get datetime values - either from combined fields or separate fields
        $leavingDate = $this->request->getPost('leaving_date_combined') ?: $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date_combined') ?: $this->request->getPost('return_date');
        
        // Validate datetime format
        if (empty($leavingDate) || empty($returnDate)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Leaving and return dates are required.');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        if ($leavingDate >= $returnDate) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Return date & time must be after leaving date & time!');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check for conflicts unless force_save is set
        if (!$this->request->getPost('force_save')) {
            $conflicts = $this->checkScheduleConflicts(
                $this->request->getPost('people_id'),
                $this->request->getPost('vehicle_id'),
                $leavingDate,
                $returnDate
            );
            
            if (!empty($conflicts)) {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'Schedule conflict detected but data was saved.');
            }
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->vtripModel->insert($data)) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully added...');
            } else {
                throw new \Exception('Database insert failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'VTrip store error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to save data. Please try again.');
        }

        return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Check vehicle conflicts API endpoint
     */
    public function checkVehicleConflict()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        $vehicleId = $this->request->getPost('vehicle_id');
        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');
        $excludeId = $this->request->getPost('exclude_id'); // For edit operations

        if (empty($vehicleId) || empty($leavingDate) || empty($returnDate)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required parameters'
            ]);
        }

        // Check for vehicle conflicts
        $conflictsQuery = $this->vtripModel
            ->select('v_trip.*, vehicle.vehicle_name, vehicle.number_plate, people.name as people_name')
            ->join('vehicle', 'vehicle.id = v_trip.vehicle_id', 'left')
            ->join('people', 'people.id = v_trip.people_id', 'left')
            ->where('v_trip.vehicle_id', $vehicleId)
            ->where('v_trip.deleted_at', null)
            ->groupStart()
                ->where('v_trip.leave_date <=', $returnDate)
                ->where('v_trip.return_date >=', $leavingDate)
            ->groupEnd();
            
        // Exclude current record if editing
        if (!empty($excludeId)) {
            $conflictsQuery->where('v_trip.id !=', $excludeId);
        }
        
        $conflicts = $conflictsQuery->findAll();

        if (!empty($conflicts)) {
            // Get vehicle info
            $vehicleInfo = $this->vehicleModel->find($vehicleId);
            $conflictInfo = $conflicts[0]; // Get first conflict for display
            
            return $this->response->setJSON([
                'success' => false,
                'has_conflict' => true,
                'message' => 'Vehicle conflict detected',
                'conflict_details' => [
                    'vehicle_name' => $vehicleInfo['vehicle_name'] ?? 'Unknown',
                    'number_plate' => $vehicleInfo['number_plate'] ?? 'Unknown',
                    'used_until' => date('D, d M Y', strtotime($conflictInfo['return_date'])),
                    'used_by' => $conflictInfo['people_name'] ?? 'Unknown'
                ]
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'has_conflict' => false,
            'message' => 'No conflicts found'
        ]);
    }

    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflicts($peopleId, $vehicleId, $leaveDate, $returnDate, $excludeId = null)
    {
        $conflicts = [];
        
        // Check people conflicts
        $peopleConflicts = $this->vtripModel
            ->where('people_id', $peopleId)
            ->where('deleted_at', null)
            ->groupStart()
                ->where('leave_date <=', $returnDate)
                ->where('return_date >=', $leaveDate)
            ->groupEnd();
            
        if ($excludeId) {
            $peopleConflicts->where('id !=', $excludeId);
        }
        
        $peopleConflicts = $peopleConflicts->findAll();
        
        if (!empty($peopleConflicts)) {
            $conflicts['people'] = $peopleConflicts;
        }
        
        // Check vehicle conflicts
        $vehicleConflicts = $this->vtripModel
            ->where('vehicle_id', $vehicleId)
            ->where('deleted_at', null)
            ->groupStart()
                ->where('leave_date <=', $returnDate)
                ->where('return_date >=', $leaveDate)
            ->groupEnd();
            
        if ($excludeId) {
            $vehicleConflicts->where('id !=', $excludeId);
        }
        
        $vehicleConflicts = $vehicleConflicts->findAll();
        
        if (!empty($vehicleConflicts)) {
            $conflicts['vehicle'] = $vehicleConflicts;
        }
        
        return $conflicts;
    }

    /**
     * Delete all trips for a specific vehicle
     */
    public function deleteAllByVehicle()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        $vehicleName = $this->request->getPost('vehicle_name');
        $number_plate = $this->request->getPost('number_plate');
        
        if (empty($vehicleName) || empty($number_plate)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Vehicle information is required.'
            ]);
        }

        try {
            // Find all trips for this vehicle
            $vehicle = $this->vehicleModel->where('vehicle_name', $vehicleName)
                                         ->where('number_plate', $number_plate)
                                         ->first();
            
            if (!$vehicle) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Vehicle not found.'
                ]);
            }

            $trips = $this->vtripModel->where('vehicle_id', $vehicle['id'])
                                    ->where('deleted_at', null)
                                    ->findAll();
            
            $deletedCount = 0;
            foreach ($trips as $trip) {
                if ($this->vtripModel->update($trip['id'], ['deleted_at' => date('Y-m-d H:i:s')])) {
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => "Successfully deleted {$deletedCount} trip(s) for {$vehicleName} - {$number_plate}."
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No trips found to delete.'
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
     * Delete all trips with flash message for a specific vehicle
     */
    public function deleteAllByVehicleWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'Not authenticated.');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $vehicleName = $this->request->getPost('vehicle_name');
        $number_plate = $this->request->getPost('number_plate');
        
        if (empty($vehicleName) || empty($number_plate)) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'Vehicle information is required.');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            // Find all trips for this vehicle
            $vehicle = $this->vehicleModel->where('vehicle_name', $vehicleName)
                                         ->where('number_plate', $number_plate)
                                         ->first();
            
            if (!$vehicle) {
                session()->setFlashdata('notification_type', 'error');
                session()->setFlashdata('notification_message', 'Vehicle not found.');
                return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }

            $trips = $this->vtripModel->where('vehicle_id', $vehicle['id'])
                                    ->where('deleted_at', null)
                                    ->findAll();
            
            $deletedCount = 0;
            foreach ($trips as $trip) {
                if ($this->vtripModel->update($trip['id'], ['deleted_at' => date('Y-m-d H:i:s')])) {
                    $deletedCount++;
                }
            }

            if ($deletedCount > 0) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', "Successfully deleted {$deletedCount} trip(s) for {$vehicleName} - {$number_plate}.");
            } else {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'No trips found to delete.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('notification_type', 'error');
            session()->setFlashdata('notification_message', 'An error occurred: ' . $e->getMessage());
        }

        return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Menampilkan form untuk menambah V-trip dan daftar sementara.
     */
    public function create()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Tambah V-Trip',
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'vehicles' => $this->vehicleModel->getAllVehicles(),
            'tmp_vtrips' => $this->tmpVtripModel->getAllTmpVTripWithDetails()
        ];

        return view('vtrip/create', $data);
    }

    /**
     * Menambahkan data V-trip ke tabel sementara.
     */
    public function addToTemp()
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not authenticated.']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'requestBy' => 'required|min_length[3]|max_length[255]',
            'leaveDate' => 'required|valid_date[Y-m-d\TH:i]',
            'returnDate' => 'required|valid_date[Y-m-d\TH:i]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Validation failed.', 'errors' => $validation->getErrors()]);
        }

        $leaveDate = $this->request->getPost('leaveDate');
        $returnDate = $this->request->getPost('returnDate');

        if ($leaveDate >= $returnDate) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tanggal & waktu kembali harus setelah tanggal & waktu pergi!']);
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'requestBy' => $this->request->getPost('requestBy'),
            'leaveDate' => $leaveDate,
            'returnDate' => $returnDate,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->tmpVtripModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil ditambahkan ke daftar sementara V-Trip!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menambahkan data V-Trip!']);
        }
    }

    /**
     * Menampilkan form edit untuk data V-trip sementara.
     *
     * @param int $id ID data sementara
     */
    public function editTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $tmpVtrip = $this->tmpVtripModel->find($id);
        if (!$tmpVtrip) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data sementara V-Trip tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Sementara V-Trip',
            'tmpVtrip' => $tmpVtrip,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'vehicles' => $this->vehicleModel->getAllVehicles()
        ];

        return view('vtrip/edit_temp', $data);
    }

    /**
     * Memperbarui data V-trip sementara.
     *
     * @param int $id ID data sementara
     */
    public function updateTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'requestBy' => 'required|min_length[3]|max_length[255]',
            'leaveDate' => 'required|valid_date[Y-m-d\TH:i]',
            'returnDate' => 'required|valid_date[Y-m-d\TH:i]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $leaveDate = $this->request->getPost('leaveDate');
        $returnDate = $this->request->getPost('returnDate');

        if ($leaveDate >= $returnDate) {
            return redirect()->back()->withInput()->with('error', 'Tanggal & waktu kembali harus setelah tanggal & waktu pergi!');
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'requestBy' => $this->request->getPost('requestBy'),
            'leaveDate' => $leaveDate,
            'returnDate' => $returnDate
        ];

        if ($this->tmpVtripModel->update($id, $data)) {
            return redirect()->to('/vtrip/create')->with('success', 'Data sementara V-Trip berhasil diupdate!');
        } else {
            return redirect()->back()->with('error', 'Gagal update data sementara V-Trip!');
        }
    }

    /**
     * Menghapus data V-trip sementara.
     *
     * @param int $id ID data sementara
     */
    public function deleteTemp($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        if ($this->tmpVtripModel->delete($id)) {
            return redirect()->back()->with('success', 'Data sementara V-Trip berhasil dihapus!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data sementara V-Trip!');
        }
    }

    /**
     * Menyimpan semua data dari tabel sementara ke tabel utama V-trip.
     */
    public function saveAll()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $tmpData = $this->tmpVtripModel->findAll();
        if (empty($tmpData)) {
            return redirect()->back()->with('error', 'Tidak ada data V-Trip sementara untuk disimpan!');
        }

        if ($this->tmpVtripModel->moveToMainTable()) {
            return redirect()->to('/vtrip')->with('success', 'Semua data V-Trip berhasil disimpan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data V-Trip!');
        }
    }

    /**
     * Mengosongkan semua data dari tabel sementara.
     */
    public function clearTemp()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        if ($this->tmpVtripModel->clearAll()) {
            return redirect()->back()->with('success', 'Daftar sementara V-Trip berhasil dibersihkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal membersihkan daftar sementara V-Trip!');
        }
    }

    /**
     * Menampilkan form edit untuk data V-trip permanen.
     *
     * @param int $id ID data V-trip
     */
    public function edit($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $vtrip = $this->vtripModel->getVTripById($id);
        if (!$vtrip) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data V-Trip tidak ditemukan');
        }

        $data = [
            'title' => 'Edit V-Trip',
            'vtrip' => $vtrip,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'vehicles' => $this->vehicleModel->getAllVehicles()
        ];

        return view('vtrip/edit', $data);
    }

    /**
     * Mengambil detail V-trip (untuk AJAX).
     *
     * @param int $id ID data V-trip
     */
    public function getVTripDetails($id)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not authenticated.']);
        }
        $vtrip = $this->vtripModel->getVTripById($id);
        if ($vtrip) {
            return $this->response->setJSON(['status' => 'success', 'data' => $vtrip]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data V-Trip tidak ditemukan.']);
        }
    }

    /**
     * Memperbarui data V-trip permanen (untuk AJAX).
     *
     * @param int $id ID data V-trip
     */
    public function update($id = null)
    {
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated.']);
        }

        // Get ID from POST data if not provided in URL
        if ($id === null) {
            $id = $this->request->getPost('vtrip_id');
        }

        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid V-Trip ID.']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date[Y-m-d\TH:i]',
            'return_date' => 'required|valid_date[Y-m-d\TH:i]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed.', 'errors' => $validation->getErrors()]);
        }

        $leavingDate = $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date');

        if ($leavingDate >= $returnDate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Return date & time must be after leaving date & time!']);
        }

        // Check for conflicts (excluding current record)
        $conflicts = $this->checkScheduleConflicts(
            $this->request->getPost('people_id'),
            $this->request->getPost('vehicle_id'),
            $leavingDate,
            $returnDate,
            $id
        );
        
        if (!empty($conflicts) && !$this->request->getPost('force_save')) {
            return $this->response->setStatusCode(409)->setJSON([
                'success' => false,
                'message' => 'Schedule conflict detected',
                'conflicts' => $conflicts
            ]);
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leaveDate' => $leavingDate,
            'returnDate' => $returnDate
        ];

        if ($this->vtripModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data V-Trip berhasil diupdate!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal update data V-Trip!']);
        }
    }

    /**
     * Update V-Trip data with flash message (for page refresh scenarios)
     */
    public function updateWithFlash()
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Get ID from POST data
        $id = $this->request->getPost('vtrip_id');

        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'V-Trip ID is required');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Validation failed: ' . implode(', ', $validation->getErrors()));
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Get datetime values - either from combined fields or separate fields
        $leavingDate = $this->request->getPost('leaving_date_combined') ?: $this->request->getPost('leaving_date');
        $returnDate = $this->request->getPost('return_date_combined') ?: $this->request->getPost('return_date');
        
        // Validate datetime format
        if (empty($leavingDate) || empty($returnDate)) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Leaving and return dates are required.');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        if ($leavingDate >= $returnDate) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Return date & time must be after leaving date & time!');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Check for conflicts unless force_save is set
        if (!$this->request->getPost('force_save')) {
            $conflicts = $this->checkScheduleConflicts(
                $this->request->getPost('people_id'),
                $this->request->getPost('vehicle_id'),
                $leavingDate,
                $returnDate,
                $id // exclude current record from conflict check
            );
            
            if (!empty($conflicts)) {
                session()->setFlashdata('notification_type', 'warning');
                session()->setFlashdata('notification_message', 'Schedule conflict detected but data was updated.');
            }
        }

        // Prepare update data
        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leaveDate' => $leavingDate,
            'returnDate' => $returnDate,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->vtripModel->update($id, $data)) {
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully edited...');
            } else {
                throw new \Exception('Database update failed');
            }
        } catch (\Exception $e) {
            log_message('error', 'VTrip update error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to update data. Please try again.');
        }

        return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
    }

    /**
     * Menghapus data V-trip secara lunak (untuk AJAX).
     */
    /**
 * Menghapus data V-trip secara lunak (untuk AJAX).
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

    if (!$id) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'V-Trip ID is required'
        ]);
    }

    // Check if record exists
    $existingData = $this->vtripModel->find($id);
    if (!$existingData) {
        return $this->response->setStatusCode(404)->setJSON([
            'success' => false,
            'message' => 'V-Trip data not found'
        ]);
    }

    try {
        if ($this->vtripModel->delete($id)) { // or softDelete($id) if you have soft delete
            return $this->response->setJSON([
                'success' => true,
                'message' => 'V-Trip data successfully deleted!'
            ]);
        } else {
            throw new \Exception('Database delete failed');
        }
    } catch (\Exception $e) {
        log_message('error', 'VTrip delete error: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Failed to delete data. Please try again.'
        ]);
    }
}

    /**
     * Delete V-Trip data with flash message (for page refresh scenarios)
     */
    public function deleteWithFlash($id = null)
    {
        if (!session()->get('admin_logged_in')) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Unauthorized access');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        // Get ID from URL parameter or POST data
        if (!$id) {
            $id = $this->request->getPost('vtrip_id');
        }

        if (!$id) {
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'V-Trip ID is required');
            return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
        }

        try {
            // Check if record exists
            $existingData = $this->vtripModel->find($id);
            if (!$existingData) {
                session()->setFlashdata('notification_type', 'danger');
                session()->setFlashdata('notification_message', 'V-Trip data not found');
                return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
            }

            log_message('info', 'Attempting to delete V-Trip with ID: ' . $id);
            
            // Try model delete first
            if ($this->vtripModel->delete($id)) {
                log_message('info', 'V-Trip deleted successfully: ' . $id);
                session()->setFlashdata('notification_type', 'success');
                session()->setFlashdata('notification_message', 'Data successfully deleted...');
            } else {
                // If model delete fails, try direct database update
                log_message('info', 'Model delete failed, trying direct database update for ID: ' . $id);
                $db = \Config\Database::connect();
                $result = $db->table('v_trip')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
                
                if ($result) {
                    log_message('info', 'Direct database delete successful for ID: ' . $id);
                    session()->setFlashdata('notification_type', 'success');
                    session()->setFlashdata('notification_message', 'Data successfully deleted...');
                } else {
                    throw new \Exception('Both model and direct database delete failed');
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'VTrip delete error: ' . $e->getMessage());
            session()->setFlashdata('notification_type', 'danger');
            session()->setFlashdata('notification_message', 'Failed to delete data. Please try again.');
        }

        return redirect()->to('vtrip' . (($this->request->getPost('config_mode') || $this->request->getGet('config_mode')) ? '?config=1' : ''));
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
            $tmpData = $this->tmpVtripModel->getAllTmpVTripWithDetails();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $tmpData
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Vtrip getTempData error: ' . $e->getMessage());
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

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date[Y-m-d\TH:i]',
            'return_date' => 'required|valid_date[Y-m-d\TH:i]'
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

        if ($leavingDate >= $returnDate) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Return date & time must be after leaving date & time!'
            ]);
        }

        // Prepare data for temporary table
        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leave_date' => $leavingDate,
            'return_date' => $returnDate,
            'admin_id' => session()->get('admin_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($this->tmpVtripModel->insert($data)) {
                // Get the newly inserted data with details
                $insertId = $this->tmpVtripModel->getInsertID();
                $insertedData = $this->tmpVtripModel
                    ->select('tmp_vtrip.*, vehicle.number_plate, vehicle.vehicle_name, people.name as people_name, destination.destination_name')
                    ->join('vehicle', 'vehicle.id = tmp_vtrip.vehicle_id')
                    ->join('people', 'people.id = tmp_vtrip.people_id')
                    ->join('destination', 'destination.id = tmp_vtrip.destination_id')
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
            log_message('error', 'Vtrip addToTempData error: ' . $e->getMessage());
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

        $tmpData = $this->tmpVtripModel->where('admin_id', session()->get('admin_id'))->find($id);
        if (!$tmpData) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Temporary data not found'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'vehicle_id' => 'required|integer',
            'people_id' => 'required|integer',
            'destination_id' => 'required|integer',
            'leaving_date' => 'required|valid_date[Y-m-d\TH:i]',
            'return_date' => 'required|valid_date[Y-m-d\TH:i]'
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

        if ($leavingDate >= $returnDate) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Return date & time must be after leaving date & time!'
            ]);
        }

        $data = [
            'vehicle_id' => $this->request->getPost('vehicle_id'),
            'people_id' => $this->request->getPost('people_id'),
            'destination_id' => $this->request->getPost('destination_id'),
            'leave_date' => $leavingDate,
            'return_date' => $returnDate
        ];

        try {
            if ($this->tmpVtripModel->update($id, $data)) {
                // Get the updated data with details
                $updatedData = $this->tmpVtripModel
                    ->select('tmp_vtrip.*, vehicle.number_plate, vehicle.vehicle_name, people.name as people_name, destination.destination_name')
                    ->join('vehicle', 'vehicle.id = tmp_vtrip.vehicle_id')
                    ->join('people', 'people.id = tmp_vtrip.people_id')
                    ->join('destination', 'destination.id = tmp_vtrip.destination_id')
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
            log_message('error', 'Vtrip editTempData error: ' . $e->getMessage());
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

        $tmpData = $this->tmpVtripModel->where('admin_id', session()->get('admin_id'))->find($id);
        if (!$tmpData) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Temporary data not found'
            ]);
        }

        try {
            if ($this->tmpVtripModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Temporary data successfully deleted'
                ]);
            } else {
                throw new \Exception('Failed to delete temporary data');
            }
        } catch (\Exception $e) {
            log_message('error', 'Vtrip deleteTempData error: ' . $e->getMessage());
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
            $tmpData = $this->tmpVtripModel->where('admin_id', session()->get('admin_id'))->findAll();
            if (empty($tmpData)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'No temporary data to save'
                ]);
            }

            // Move all data from temporary to main table
            if ($this->tmpVtripModel->moveToMainTable()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'All V-Trip data successfully saved!',
                    'saved_count' => count($tmpData)
                ]);
            } else {
                throw new \Exception('Failed to move data to main table');
            }
        } catch (\Exception $e) {
            log_message('error', 'Vtrip saveAllTempData error: ' . $e->getMessage());
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
            if ($this->tmpVtripModel->clearAll()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'All temporary data cleared'
                ]);
            } else {
                throw new \Exception('Failed to clear temporary data');
            }
        } catch (\Exception $e) {
            log_message('error', 'Vtrip clearAllTempData error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to clear temporary data'
            ]);
        }
    }
}