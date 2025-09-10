<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table            = 'employee';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['employee_id', 'email', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'employee_id' => 'required|is_unique[employee.employee_id]|integer',
        'email'       => 'required|valid_email|is_unique[employee.email]'
    ];
    protected $validationMessages   = [
        'employee_id' => [
            'required'  => 'Employee ID is required',
            'is_unique' => 'Employee ID already exists',
            'integer'   => 'Employee ID must be a number'
        ],
        'email' => [
            'required'     => 'Email is required',
            'valid_email'  => 'Please enter a valid email address',
            'is_unique'    => 'Email already exists'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    
    /**
     * Find employee by employee_id
     */
    public function findByEmployeeId($employeeId)
    {
        return $this->where('employee_id', $employeeId)->first();
    }
    
    /**
     * Find employee by email
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
    
    /**
     * Check if employee exists by employee_id
     */
    public function isValidEmployee($employeeId)
    {
        return $this->where('employee_id', $employeeId)->countAllResults() > 0;
    }

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
