<?php
// File: app/Models/PeopleModel.php

namespace App\Models;

use CodeIgniter\Model;

class PeopleModel extends Model
{
    protected $table = 'people';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

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
    protected $beforeUpdate = ['beforeUpdate'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    // Custom methods
    public function getActivePeople($limit = null)
    {
        $builder = $this->where('deleted_at', null)
                       ->orderBy('name', 'ASC');
        
        if ($limit) {
            return $builder->limit($limit)->findAll();
        }
        
        return $builder->findAll();
    }

    public function searchByName($keyword)
    {
        return $this->where('deleted_at', null)
                   ->like('name', $keyword)
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    public function checkDuplicateName($name, $excludeId = null)
    {
        $builder = $this->where('name', $name)
                       ->where('deleted_at', null);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->first();
    }

    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }
    public function getAllPeople()
    {
        return $this->where('deleted_at', null)->findAll();
    }
    
    public function getPeopleById($id)
    {
        return $this->where('id', $id)->where('deleted_at', null)->first();
    }
    
    public function softDelete($id)
    {
        return $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
    }
}