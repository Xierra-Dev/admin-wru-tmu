<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $table            = 'destination';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['destination_name'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'destination_name' => 'required|min_length[2]|max_length[100]'
    ];
    protected $validationMessages   = [
        'destination_name' => [
            'required'      => 'Nama destinasi wajib diisi',
            'min_length'    => 'Nama destinasi minimal 2 karakter',
            'max_length'    => 'Nama destinasi maksimal 100 karakter',
            'is_unique'     => 'Nama destinasi sudah ada'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeInsert(array $data)
    {
        return $this->cleanDestinationName($data);
    }

    protected function beforeUpdate(array $data)
    {
        return $this->cleanDestinationName($data);
    }

    private function cleanDestinationName(array $data)
    {
        if (isset($data['data']['destination_name'])) {
            $data['data']['destination_name'] = trim($data['data']['destination_name']);
        }
        return $data;
    }

    /**
     * Get all destinations with optional search
     */
    public function getDestinations($search = null)
    {
        $builder = $this->builder();
        
        // Only get non-deleted destinations
        $builder->where('deleted_at', null);
        
        if (!empty($search)) {
            $builder->like('destination_name', $search);
        }
        
        return $builder->orderBy('destination_name', 'ASC')->get()->getResultArray();
    }

    /**
     * Check if destination name exists (case insensitive)
     */
    public function destinationExists($name, $excludeId = null)
    {
        $builder = $this->builder();
        $builder->where('LOWER(destination_name)', strtolower($name));
        $builder->where('deleted_at', null); // Only check non-deleted destinations
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->get()->getRowArray() !== null;
    }

    /**
     * Get destinations for dropdown/select options
     */
    public function getDestinationOptions()
    {
        return $this->where('deleted_at', null)
                   ->orderBy('destination_name', 'ASC')
                   ->findAll();
    }

    /**
     * Bulk insert destinations
     */
    public function bulkInsert($destinations)
    {
        if (empty($destinations)) {
            return false;
        }

        $insertData = [];
        foreach ($destinations as $destination) {
            if (is_string($destination)) {
                $insertData[] = [
                    'destination_name' => trim($destination),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            } elseif (is_array($destination) && isset($destination['destination_name'])) {
                $insertData[] = [
                    'destination_name' => trim($destination['destination_name']),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        if (!empty($insertData)) {
            return $this->insertBatch($insertData);
        }

        return false;
    }

    /**
     * Get paginated destinations with search functionality
     */
    // public function getPaginatedDestinations($perPage = 10, $search = null)
    // {
    //     $builder = $this->builder();
        
    //     if (!empty($search)) {
    //         $builder->like('destination_name', $search);
    //     }
        
    //     return $builder->orderBy('destination_name', 'ASC')
    //                   ->paginate($perPage);
    // }
    public function getAllDestinations()
    {
        return $this->where('deleted_at', null)->findAll();
    }
    
    public function getDestinationById($id)
    {
        return $this->where('id', $id)->where('deleted_at', null)->first();
    }
    
    public function softDelete($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }
}


