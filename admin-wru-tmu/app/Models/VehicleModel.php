<?php
// app/Models/VehicleModel.php
namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicle';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'vehicle_name',
        'number_plate',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

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
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get all vehicles with search functionality
     */
    public function getVehicles($search = null, $limit = 10, $offset = 0)
    {
        $builder = $this->builder();
        
        if ($search) {
            $builder->groupStart()
                   ->like('vehicle_name', $search)
                   ->orLike('number_plate', $search)
                   ->groupEnd();
        }
        
        return $builder->orderBy('created_at', 'DESC')
                      ->limit($limit, $offset)
                      ->get()
                      ->getResultArray();
    }

    /**
     * Count vehicles with search functionality
     */
    public function countVehicles($search = null)
    {
        $builder = $this->builder();
        
        if ($search) {
            $builder->groupStart()
                   ->like('vehicle_name', $search)
                   ->orLike('number_plate', $search)
                   ->groupEnd();
        }
        
        return $builder->countAllResults();
    }

    /**
     * Check if number plate is unique
     */
    public function isNumberPlateUnique($numberPlate, $excludeId = null)
    {
        $builder = $this->builder();
        $builder->where('number_plate', $numberPlate);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() === 0;
    }

    /**
     * Get vehicle by number plate
     */
    public function getByNumberPlate($numberPlate)
    {
        return $this->where('number_plate', $numberPlate)->first();
    }

    /**
     * Get vehicles for dropdown/select options
     */
    public function getVehicleOptions()
    {
        $vehicles = $this->select('id, vehicle_name, number_plate')
                        ->orderBy('vehicle_name', 'ASC')
                        ->findAll();
        
        $options = [];
        foreach ($vehicles as $vehicle) {
            $options[$vehicle['id']] = $vehicle['vehicle_name'] . ' - ' . $vehicle['number_plate'];
        }
        
        return $options;
    }

    /**
     * Bulk insert vehicles
     */
    public function bulkinsert($data)
    {
        if (empty($data)) {
            return false;
        }

        // Add timestamps to all records
        $currentTime = date('Y-m-d H:i:s');
        foreach ($data as &$record) {
            $record['created_at'] = $currentTime;
            $record['updated_at'] = $currentTime;
        }

        return $this->db->table($this->table)->insertBatch($data);
    }

    /**
     * Get vehicle statistics
     */
    public function getStatistics()
    {
        $total = $this->countAllResults();
        $recent = $this->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                      ->countAllResults();
        
        return [
            'total' => $total,
            'recent' => $recent
        ];
    }
    public function getAllVehicles()
    {
        return $this->where('deleted_at', null)->findAll();
    }
    
    public function getVehicleById($id)
    {
        return $this->where('id', $id)->where('deleted_at', null)->first();
    }
    
    public function softDelete($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }
    
    public function getFormattedVehicles()
    {
        $vehicles = $this->getAllVehicles();
        $formatted = [];
        foreach ($vehicles as $vehicle) {
            $formatted[] = [
                'id' => $vehicle['id'],
                'display_name' => $vehicle['vehicle_name'] . ' - ' . $vehicle['number_plate'],
                'vehicle_name' => $vehicle['vehicle_name'],
                'number_plate' => $vehicle['number_plate']
            ];
        }
        return $formatted;
    }
}