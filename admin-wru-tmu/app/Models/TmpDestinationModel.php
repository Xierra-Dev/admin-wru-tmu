<?php

namespace App\Models;

use CodeIgniter\Model;

class TmpDestinationModel extends Model
{
    protected $table            = 'tmp_destination';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['destination_name', 'admin_id', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = null; // No updated_at in tmp table

    // Validation
    protected $validationRules      = [
        'destination_name' => 'required|min_length[2]|max_length[255]'
    ];
    protected $validationMessages   = [
        'destination_name' => [
            'required'      => 'Nama destinasi wajib diisi',
            'min_length'    => 'Nama destinasi minimal 2 karakter',
            'max_length'    => 'Nama destinasi maksimal 255 karakter'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get all temporary destinations for current admin
     */
    public function getAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Clear all temporary destinations for current admin
     */
    public function clearAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

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
        if (isset($data['data']['destination_name'])) {
            $data['data']['destination_name'] = trim($data['data']['destination_name']);
        }
        
        // Automatically set admin_id from session if not provided
        if (!isset($data['data']['admin_id'])) {
            $data['data']['admin_id'] = session()->get('admin_id');
        }
        
        // Set created_at if not provided
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data']['destination_name'])) {
            $data['data']['destination_name'] = trim($data['data']['destination_name']);
        }
        return $data;
    }

    /**
     * Check if destination exists in tmp table for current admin
     */
    public function destinationExistsInTmp($name)
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                   ->where('LOWER(destination_name)', strtolower(trim($name)))
                   ->first() !== null;
    }

    /**
     * Clean up old tmp records (older than 24 hours)
     */
    public function cleanupOldRecords()
    {
        $cutoffTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
        return $this->where('created_at <', $cutoffTime)->delete();
    }

    /**
     * Bulk insert tmp destinations for current admin
     */
    public function bulkInsert($destinations)
    {
        if (empty($destinations)) {
            return false;
        }

        $insertData = [];
        $adminId = session()->get('admin_id');
        
        foreach ($destinations as $destination) {
            if (is_string($destination)) {
                $insertData[] = [
                    'destination_name' => trim($destination),
                    'admin_id' => $adminId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } elseif (is_array($destination) && isset($destination['destination_name'])) {
                $insertData[] = [
                    'destination_name' => trim($destination['destination_name']),
                    'admin_id' => $adminId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        if (!empty($insertData)) {
            return parent::insertBatch($insertData);
        }

        return false;
    }
}