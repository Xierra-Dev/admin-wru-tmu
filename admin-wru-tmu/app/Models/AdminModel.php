<?php
// app/Models/AdminModel.php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employee_id', 'password', 'email', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function createAdmin($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }
    public function updateProfile($id, $data)
    {
        // Pastikan password tidak ikut terupdate di method ini
        unset($data['password']);
        
        return $this->update($id, $data);
    }

    // NEW METHOD: Update password saja
    public function updatePassword($id, $newPassword)
    {
        return $this->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    // NEW METHOD: Get admin by email (untuk check duplicate)
    public function getAdminByEmail($email, $excludeId = null)
    {
        $builder = $this->where('email', $email);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->first();
    }

    // NEW METHOD: Get admin by employee_id (untuk check duplicate)
    public function getAdminByEmployeeId($employeeId, $excludeId = null)
    {
        $builder = $this->where('employee_id', $employeeId);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->first();
    }
    
    
    public function getAdminByemployee($employee)
    {
        return $this->where('employee_id', $employee)->first();
    }
    
    // NEW METHOD: Get admin by both employee_id and email for secure login
    public function getAdminByCredentials($employeeId, $email)
    {
        return $this->where('employee_id', $employeeId)
                   ->where('email', $email)
                   ->first();
    }
}