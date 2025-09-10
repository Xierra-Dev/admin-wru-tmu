<?php

namespace App\Controllers;

use App\Models\MlocModel;
use App\Models\VtripModel;
use App\Models\PeopleModel;
use App\Models\DestinationModel;
use App\Models\VehicleModel;
use CodeIgniter\Controller;

class History extends BaseController
{
    protected $mlocModel;
    protected $vtripModel;
    protected $peopleModel;
    protected $destinationModel;
    protected $vehicleModel;

    public function __construct()
    {
        $this->mlocModel = new MlocModel();
        $this->vtripModel = new VtripModel();
        $this->peopleModel = new PeopleModel();
        $this->destinationModel = new DestinationModel();
        $this->vehicleModel = new VehicleModel();
    }

    /**
     * Main history page - shows overview or redirects to M-Loc history
     */
    public function index()
    {
        return redirect()->to(base_url('history/mloc'));
    }

    /**
     * M-Loc History - shows past M-Loc records
     */
    public function mloc()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get current date
        $today = date('Y-m-d');
        
        // Get past M-Loc records (return_date is before today)
        $allMlocs = $this->mlocModel
                        ->select('m_loc.*, people.name as people_name, destination.destination_name')
                        ->join('people', 'people.id = m_loc.people_id')
                        ->join('destination', 'destination.id = m_loc.destination_id')
                        ->where('m_loc.deleted_at', null)
                        ->where('people.deleted_at', null)
                        ->where('destination.deleted_at', null)
                        ->where('m_loc.return_date <', $today)
                        ->orderBy('people.name', 'ASC')
                        ->orderBy('m_loc.leave_date', 'DESC')
                        ->findAll();
        
        // Expand each schedule into daily cards (same as Schedule page)
        $expandedMlocs = [];
        foreach ($allMlocs as $mloc) {
            $dailyCards = $this->generateDailyCards($mloc);
            $expandedMlocs = array_merge($expandedMlocs, $dailyCards);
        }
        
        // Group data by person name (same structure as Schedule page)
        $groupedMlocs = [];
        foreach ($expandedMlocs as $mloc) {
            $peopleName = $mloc['people_name'];
            if (!isset($groupedMlocs[$peopleName])) {
                $groupedMlocs[$peopleName] = [];
            }
            $groupedMlocs[$peopleName][] = $mloc;
        }

        $data = [
            'title' => 'M-Loc History',
            'groupedMlocs' => $groupedMlocs,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
        ];

        return view('history/mloc', $data);
    }

    /**
     * V-Trip History - shows past V-Trip records  
     */
    public function vtrip()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get current date
        $today = date('Y-m-d');
        
        // Get past V-Trip records (return_date is before today)
        $allVtrips = $this->vtripModel
                        ->select('v_trip.*, vehicle.vehicle_name, vehicle.number_plate, people.name as people_name, destination.destination_name')
                        ->join('vehicle', 'vehicle.id = v_trip.vehicle_id', 'left')
                        ->join('people', 'people.id = v_trip.people_id', 'left')
                        ->join('destination', 'destination.id = v_trip.destination_id', 'left')
                        ->where('v_trip.deleted_at', null)
                        ->where('vehicle.deleted_at', null)
                        ->where('people.deleted_at', null)
                        ->where('destination.deleted_at', null)
                        ->where('v_trip.return_date <', $today)
                        ->orderBy('vehicle.vehicle_name', 'ASC')
                        ->orderBy('v_trip.leave_date', 'DESC')
                        ->findAll();
        
        // Expand each trip into daily cards (same as Schedule page)
        $expandedVtrips = [];
        foreach ($allVtrips as $vtrip) {
            $dailyCards = $this->generateDailyCards($vtrip);
            $expandedVtrips = array_merge($expandedVtrips, $dailyCards);
        }
        
        // Group data by vehicle name (same structure as Schedule page)
        $groupedVtrips = [];
        foreach ($expandedVtrips as $vtrip) {
            $vehicleKey = $vtrip['vehicle_name'] . ' (' . $vtrip['number_plate'] . ')';
            if (!isset($groupedVtrips[$vehicleKey])) {
                $groupedVtrips[$vehicleKey] = [];
            }
            $groupedVtrips[$vehicleKey][] = $vtrip;
        }

        $data = [
            'title' => 'V-Trip History',
            'groupedVtrips' => $groupedVtrips,
            'people' => $this->peopleModel->getAllPeople(),
            'destinations' => $this->destinationModel->getAllDestinations(),
            'vehicles' => $this->vehicleModel->getAllVehicles(),
        ];

        return view('history/vtrip', $data);
    }

    /**
     * Generate daily schedule cards based on date range (same as Schedule pages)
     */
    private function generateDailyCards($record)
    {
        $dailyCards = [];
        $startDate = new \DateTime($record['leave_date']);
        $endDate = new \DateTime($record['return_date']);
        
        // If same day, create one card
        if ($startDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
            $dailyCards[] = $record;
            return $dailyCards;
        }
        
        // Create cards for each day in the range
        $currentDate = clone $startDate;
        $dayNumber = 1;
        
        while ($currentDate <= $endDate) {
            $dayCard = $record;
            $dayCard['leave_date'] = $currentDate->format('Y-m-d H:i:s');
            $dayCard['day_number'] = $dayNumber;
            $dayCard['total_days'] = $startDate->diff($endDate)->days + 1;
            $dayCard['original_id'] = $record['id']; // Keep original ID for reference
            $dayCard['daily_card_id'] = $record['id'] . '_day_' . $dayNumber; // Unique ID for each day card
            
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
}