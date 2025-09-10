<?php

// =====================================
// File: app/Models/TmpPeopleModel.php

namespace App\Models;

use CodeIgniter\Model;

class TmpPeopleModel extends Model
{
    protected $table = 'tmp_people';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'admin_id',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Nama personil harus diisi',
            'min_length' => 'Nama personil minimal 2 karakter',
            'max_length' => 'Nama personil maksimal 255 karakter'
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

    // Custom methods
    public function getAllOrderedByDate()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function checkDuplicateName($name)
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->where('name', $name)
                    ->first();
    }

    public function getTotalCount()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->countAllResults();
    }

    public function clearAll()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

    /**
     * Clear all temporary people for current admin
     */
    public function clearAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

    /**
     * Get all temporary people for current admin
     */
    public function getAllForCurrentAdmin()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    protected function beforeInsert(array $data)
    {
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        
        // Automatically set admin_id for new records
        if (!isset($data['data']['admin_id'])) {
            $data['data']['admin_id'] = session()->get('admin_id');
        }
        
        return $data;
    }
}