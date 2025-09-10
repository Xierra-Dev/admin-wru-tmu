<?php

namespace App\Models;

use CodeIgniter\Model;

class TmpVehicleModel extends Model
{
    protected $table = 'tmp_vehicle';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'vehicle_name',
        'number_plate',
        'admin_id',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // We'll handle timestamps manually
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'vehicle_name' => 'required|min_length[3]|max_length[255]',
        'number_plate' => 'required|min_length[3]|max_length[255]'
    ];

    protected $validationMessages = [
        'vehicle_name' => [
            'required' => 'Vehicle name is required',
            'min_length' => 'Vehicle name must be at least 3 characters',
            'max_length' => 'Vehicle name cannot exceed 255 characters'
        ],
        'number_plate' => [
            'required' => 'Number plate is required',
            'min_length' => 'Number plate must be at least 3 characters',
            'max_length' => 'Number plate cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['beforeInsert'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Set created_at timestamp and admin_id before insert
     */
    protected function beforeInsert(array $data)
    {
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        
        // Automatically set admin_id from session if not provided
        if (!isset($data['data']['admin_id'])) {
            $data['data']['admin_id'] = session()->get('admin_id');
        }
        
        return $data;
    }

    /**
     * Get all temporary vehicles ordered by creation date for current admin
     */
    public function getAllOrdered()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Get all temporary vehicles for current admin
     */
    public function getAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Clear all temporary vehicles for current admin
     */
    public function clearAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

    /**
     * Check if number_plate already exists in temporary table for current admin
     */
    public function isNumberPlateExists($numberPlate, $excludeId = null)
    {
        $adminId = session()->get('admin_id');
        $builder = $this->builder();
        $builder->where('admin_id', $adminId)
                ->where('number_plate', $numberPlate);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get temporary vehicle by number_plate for current admin
     */
    public function getByNumberPlate($numberPlate)
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->where('number_plate', $numberPlate)
                    ->first();
    }

    /**
     * Search temporary vehicles for current admin
     */
    public function searchTmp($search)
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                   ->groupStart()
                   ->like('vehicle_name', $search)
                   ->orLike('number_plate', $search)
                   ->groupEnd()
                   ->orderBy('created_at', 'ASC')
                   ->findAll();
    }

    /**
     * Count temporary vehicles for current admin
     */
    public function countTmp()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->countAllResults();
    }

    /**
     * Clear all temporary vehicles
     */
    public function emptyTable()
    {
        return $this->db->table($this->table)->emptyTable();
    }

    /**
     * Insert temporary vehicle with validation
     */
    public function insertTmp($data)
    {
        // Check if number_plate already exists in main table
        $vehicleModel = new \App\Models\VehicleModel();
        $existingVehicle = $vehicleModel->where('number_plate', $data['number_plate'])->first();
        
        if ($existingVehicle) {
            return [
                'status' => 'error',
                'message' => 'Number plate already exists in main database'
            ];
        }

        // Check if number_plate already exists in temporary table
        if ($this->isNumberPlateExists($data['number_plate'])) {
            return [
                'status' => 'error',
                'message' => 'Number plate already exists in temporary list'
            ];
        }

        $insertId = $this->insert($data);
        
        if ($insertId) {
            return [
                'status' => 'success',
                'message' => 'Vehicle added to temporary list successfully',
                'data' => $this->find($insertId)
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Failed to add vehicle to temporary list',
                'errors' => $this->errors()
            ];
        }
    }

    /**
     * Get vehicles ready for permanent storage for current admin
     */
    public function getVehiclesForStorage()
    {
        $adminId = session()->get('admin_id');
        $tmpVehicles = $this->where('admin_id', $adminId)->findAll();
        $vehicles = [];
        
        foreach ($tmpVehicles as $tmp) {
            $vehicles[] = [
                'vehicle_name' => $tmp['vehicle_name'],
                'number_plate' => $tmp['number_plate'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        return $vehicles;
    }

    /**
     * Get temporary vehicles with pagination for current admin
     */
    public function getTmpVehiclesPaginated($perPage = 10)
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->paginate($perPage);
    }
}