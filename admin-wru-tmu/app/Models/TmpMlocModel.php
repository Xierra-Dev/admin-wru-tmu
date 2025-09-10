<?php

namespace App\Models;

use CodeIgniter\Model;

class TmpMlocModel extends Model
{
    protected $table = 'tmp_mloc';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'people_id',
        'destination_id',
        'request_by',
        'leave_date',
        'return_date',
        'letter',
        'admin_id',
        'created_at',
        'updated_at'
    ];

    public function getTmpMlocs()
    {
        return $this->select('tmp_mloc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = tmp_mloc.people_id')
                    ->join('destination', 'destination.id = tmp_mloc.destination_id')
                    ->orderBy('tmp_mloc.created_at', 'DESC')
                    ->findAll();
    }

    public function getAllTmpMLocWithDetails()
    {
        $adminId = session()->get('admin_id');
        return $this->select('tmp_mloc.*, people.name as people_name, destination.destination_name')
                    ->join('people', 'people.id = tmp_mloc.people_id')
                    ->join('destination', 'destination.id = tmp_mloc.destination_id')
                    ->where('tmp_mloc.admin_id', $adminId)
                    ->where('people.deleted_at', null)
                    ->where('destination.deleted_at', null)
                    ->orderBy('tmp_mloc.created_at', 'DESC')
                    ->findAll();
    }

    public function clearTmpMlocs()
    {
        return $this->emptyTable();
    }

    public function clearAll()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

    public function moveToMainTable()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Get all tmp data for current admin
            $adminId = session()->get('admin_id');
            $tmpData = $this->where('admin_id', $adminId)->findAll();
            
            if (empty($tmpData)) {
                return false;
            }

            // Move each record to m_loc table
            $mlocModel = new \App\Models\MlocModel();
            foreach ($tmpData as $data) {
                $insertData = [
                    'people_id' => $data['people_id'],
                    'destination_id' => $data['destination_id'],
                    'request_by' => $data['request_by'],
                    'leave_date' => $data['leave_date'],
                    'return_date' => $data['return_date'],
                    'letter' => $data['letter'] ?? 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                if (!$mlocModel->insert($insertData)) {
                    throw new \Exception('Failed to insert data to m_loc table');
                }
            }

            // Clear tmp table after successful move (only for current admin)
            $this->where('admin_id', $adminId)->delete();

            $db->transComplete();
            return $db->transStatus();

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'TmpMlocModel moveToMainTable error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Clean up old temporary data (older than 24 hours)
     */
    public function cleanupOldData()
    {
        $cutoffTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
        return $this->where('created_at <', $cutoffTime)->delete();
    }
}