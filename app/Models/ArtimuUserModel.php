<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtimuUserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false; // id is varchar(20)
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id',
        'username',
        'fullname',
        'nickname',
        'email',
        'email_verified_at',
        'password',
        'photo',
        'pm_role_id',
        'color',
        'mode',
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
    protected $deletedField = '';

    // Use the promag database connection
    protected $DBGroup = 'promag';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
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
     * Find user by id
     */
    public function findById($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Check if user exists by id and email combination
     */
    public function validateUserCredentials($id, $email)
    {
        return $this->where('id', $id)
            ->where('email', $email)
            ->first();
    }

    /**
     * Check if user ID exists
     */
    public function isValidUserId($id)
    {
        return $this->where('id', $id)->countAllResults() > 0;
    }

    /**
     * Check if email exists
     */
    public function isValidEmail($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
}
