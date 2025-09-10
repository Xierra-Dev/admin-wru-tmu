<?php

namespace App\Models;

use CodeIgniter\Model;

class MlocModel extends Model
{
    protected $table = 'm_loc';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'people_id',
        'destination_id', 
        'request_by',
        'leave_date',
        'return_date',
        'letter'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'people_id' => 'required|integer',
        'destination_id' => 'required|integer',
        'leave_date' => 'required|valid_date',
        'return_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'people_id' => [
            'required' => 'Personil must be selected',
            'integer' => 'Invalid personil selection'
        ],
        'destination_id' => [
            'required' => 'Destination must be selected',
            'integer' => 'Invalid destination selection'
        ],
        'leave_date' => [
            'required' => 'Leaving date is required',
            'valid_date' => 'Invalid leaving date format'
        ],
        'return_date' => [
            'required' => 'Return date is required',
            'valid_date' => 'Invalid return date format'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get all M-Loc data with people and destination names
     */
    public function getMlocsWithNames()
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->orderBy('people.name', 'ASC')
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get M-Loc data by ID with names
     */
    public function getMlocWithNames($id)
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.id', $id)
                    ->where('m_loc.deleted_at', null)
                    ->first();
    }

    /**
     * Get M-Loc data by people ID
     */
    public function getMlocsByPeopleId($peopleId)
    {
        return $this->where('people_id', $peopleId)
                    ->where('deleted_at', null)
                    ->orderBy('leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get M-Loc data by destination ID
     */
    public function getMlocsByDestinationId($destinationId)
    {
        return $this->select('m_loc.*, people.name as people_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->where('m_loc.destination_id', $destinationId)
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Check for schedule conflicts
     */
    public function checkScheduleConflicts($peopleId, $leaveDate, $returnDate, $excludeId = null)
    {
        $builder = $this->where('people_id', $peopleId)
                        ->where('deleted_at', null)
                        ->groupStart()
                            ->where('leave_date <=', $returnDate)
                            ->where('return_date >=', $leaveDate)
                        ->groupEnd();
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->findAll();
    }

    /**
     * Get M-Loc data by date range
     */
    public function getMlocsByDateRange($startDate, $endDate)
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->groupStart()
                        ->where('m_loc.leave_date >=', $startDate)
                        ->where('m_loc.leave_date <=', $endDate)
                    ->groupEnd()
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get M-Loc statistics
     */
    public function getMlocStats()
    {
        $total = $this->where('deleted_at', null)->countAllResults();
        
        $today = date('Y-m-d');
        $todayCount = $this->where('deleted_at', null)
                           ->where('DATE(leave_date)', $today)
                           ->countAllResults();
        
        $thisWeek = $this->where('deleted_at', null)
                         ->where('leave_date >=', date('Y-m-d', strtotime('monday this week')))
                         ->where('leave_date <=', date('Y-m-d', strtotime('sunday this week')))
                         ->countAllResults();
        
        $thisMonth = $this->where('deleted_at', null)
                          ->where('MONTH(leave_date)', date('m'))
                          ->where('YEAR(leave_date)', date('Y'))
                          ->countAllResults();

        return [
            'total' => $total,
            'today' => $todayCount,
            'this_week' => $thisWeek,
            'this_month' => $thisMonth
        ];
    }

    /**
     * Search M-Loc data
     */
    public function searchMlocs($keyword)
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->groupStart()
                        ->like('people.name', $keyword)
                        ->orLike('destination.destination_name', $keyword)
                        ->orLike('m_loc.request_by', $keyword)
                    ->groupEnd()
                    ->orderBy('people.name', 'ASC')
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get active M-Loc (current schedules)
     */
    public function getActiveMlocs()
    {
        $now = date('Y-m-d H:i:s');
        
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->where('m_loc.leave_date <=', $now)
                    ->where('m_loc.return_date >=', $now)
                    ->orderBy('m_loc.return_date', 'ASC')
                    ->findAll();
    }

    /**
     * Get upcoming M-Loc (future schedules)
     */
    public function getUpcomingMlocs($days = 7)
    {
        $now = date('Y-m-d H:i:s');
        $futureDate = date('Y-m-d H:i:s', strtotime("+$days days"));
        
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id', 'left')
                    ->join('destination', 'destination.id = m_loc.destination_id', 'left')
                    ->where('m_loc.deleted_at', null)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->where('m_loc.leave_date >=', $now)
                    ->where('m_loc.leave_date <=', $futureDate)
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    /**
     * Soft delete override with enhanced error handling
     */
    public function delete($id = null, $purge = false)
    {
        if ($purge) {
            return parent::delete($id, true);
        }

        // Check if record exists first
        $record = $this->find($id);
        if (!$record) {
            log_message('error', 'M-Loc delete failed: Record not found with ID ' . $id);
            return false;
        }

        // Check if already soft deleted
        if (!empty($record['deleted_at'])) {
            log_message('info', 'M-Loc already deleted with ID ' . $id);
            return true; // Consider already deleted as successful
        }

        try {
            $data = ['deleted_at' => date('Y-m-d H:i:s')];
            $result = $this->update($id, $data);
            
            if ($result) {
                log_message('info', 'M-Loc soft deleted successfully with ID ' . $id);
            } else {
                log_message('error', 'M-Loc soft delete failed for ID ' . $id);
            }
            
            return $result;
        } catch (\Exception $e) {
            log_message('error', 'M-Loc delete exception: ' . $e->getMessage());
            // If soft delete fails, try hard delete as fallback
            try {
                return parent::delete($id, true);
            } catch (\Exception $e2) {
                log_message('error', 'M-Loc hard delete also failed: ' . $e2->getMessage());
                return false;
            }
        }
    }
public function getMLocWithDetails()
    {
        return $this->where('deleted_at', null)->findAll();
    }
    /**
     * Restore soft deleted record
     */
    public function restore($id)
    {
        return $this->update($id, ['deleted_at' => null]);
    }

    public function getGroupedMlocs()
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id')
                    ->join('destination', 'destination.id = m_loc.destination_id')
                    ->where('m_loc.deleted_at IS NULL')
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }

    public function getAllMLocWithDetails()
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                   ->join('people', 'people.id = m_loc.people_id')
                   ->join('destination', 'destination.id = m_loc.destination_id')
                   ->where('m_loc.deleted_at', null)
                   ->findAll();
    }
    
    public function getMLocById($id)
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                   ->join('people', 'people.id = m_loc.people_id')
                   ->join('destination', 'destination.id = m_loc.destination_id')
                   ->where('m_loc.id', $id)
                   ->where('m_loc.deleted_at', null)
                   ->first();
    }
    public function getMlocsByDate($date)
    {
        return $this->select('m_loc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = m_loc.people_id')
                    ->join('destination', 'destination.id = m_loc.destination_id')
                    ->where('DATE(m_loc.leave_date)', $date)
                    ->where('m_loc.deleted_at IS NULL')
                    ->orderBy('m_loc.leave_date', 'ASC')
                    ->findAll();
    }
}