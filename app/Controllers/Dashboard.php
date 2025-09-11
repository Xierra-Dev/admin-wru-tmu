<?php
// app/Controllers/Dashboard.php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\PeopleModel;
use App\Models\DestinationModel;
use App\Models\VehicleModel;
use App\Models\MLocModel;
use App\Models\ArtimuUserModel;

class Dashboard extends BaseController
{
    protected $peopleModel;
    protected $destinationModel;
    protected $vehicleModel;
    protected $mlocModel;
    protected $adminModel;

    public function __construct()
    {
        $this->peopleModel = new PeopleModel();
        $this->destinationModel = new DestinationModel();
        $this->vehicleModel = new VehicleModel();
        $this->mlocModel = new MLocModel();
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get current time in UTC+7 timezone
        $timezone = new \DateTimeZone('Asia/Jakarta'); // UTC+7
        $currentTime = new \DateTime('now', $timezone);
        $currentHour = (int) $currentTime->format('H');

        // Determine greeting based on time
        $greeting = 'Hello'; // Default
        if ($currentHour >= 0 && $currentHour < 12) {
            $greeting = 'Good Morning';
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $greeting = 'Good Afternoon';
        } elseif ($currentHour >= 18 && $currentHour <= 23) {
            $greeting = 'Good Evening';
        }

        $data = [
            'title' => 'Dashboard',
            'greeting' => $greeting,
            'total_people' => count($this->peopleModel->getAllPeople()),
            'total_destinations' => count($this->destinationModel->getAllDestinations()),
            'total_vehicles' => count($this->vehicleModel->getAllVehicles()),
            'total_mloc' => count($this->mlocModel->getAllMLocWithDetails())
        ];

        return view('dashboard/index', $data);
    }

    public function profile()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Profile Admin'
        ];

        return view('dashboard/profile', $data);
    }

    // NEW METHOD: Update Profile
    public function updateProfile()
    {
        // Pastikan user sudah login
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ])->setStatusCode(401);
        }

        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            // Set validation rules
            $validation->setRules([
                'employee_id' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            $adminId = session()->get('admin_id');
            $employeeId = $this->request->getPost('employee_id');
            $email = $this->request->getPost('email');

            // Cek apakah email sudah digunakan oleh admin lain
            $existingAdmin = $this->adminModel
                ->where('email', $email)
                ->where('id !=', $adminId)
                ->first();

            if ($existingAdmin) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email already used by another admin'
                ]);
            }

            // Cek apakah employee_id sudah digunakan oleh admin lain
            $existingEmployee = $this->adminModel
                ->where('employee_id', $employeeId)
                ->where('id !=', $adminId)
                ->first();

            if ($existingEmployee) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Employee ID already used by another admin'
                ]);
            }

            // Update data admin
            $updateData = [
                'employee_id' => $employeeId,
                'email' => $email,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->adminModel->update($adminId, $updateData)) {
                // Update session data
                session()->set([
                    'admin_employee_id' => $employeeId,
                    'admin_email' => $email
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Profile updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to update profile'
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

    // NEW METHOD: Change Password
    public function changePassword()
    {
        // Pastikan user sudah login
        if (!session()->get('admin_logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ])->setStatusCode(401);
        }

        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            // Set validation rules
            $validation->setRules([
                'current_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            $adminId = session()->get('admin_id');
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');

            // Get admin data
            $admin = $this->adminModel->find($adminId);
            if (!$admin) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Admin not found'
                ]);
            }

            // Verify current password
            if (!password_verify($currentPassword, $admin['password'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ]);
            }

            // Update password
            $updateData = [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->adminModel->update($adminId, $updateData)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Password changed successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to change password'
                ]);
            }
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }
}
