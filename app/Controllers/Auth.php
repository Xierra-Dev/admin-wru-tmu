<?php
// app/Controllers/Auth.php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ArtimuUserModel;

class Auth extends BaseController
{
    protected $adminModel;
    protected $artimuUserModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->artimuUserModel = new ArtimuUserModel();
    }

    public function index()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/dashboard');
        }

        // Check for remember me cookie
        if (isset($_COOKIE['remember_admin'])) {
            $cookieData = json_decode(base64_decode($_COOKIE['remember_admin']), true);

            if ($cookieData && isset($cookieData['admin_id'])) {
                // Verify admin still exists in database
                $admin = $this->adminModel->find($cookieData['admin_id']);

                if ($admin) {
                    // Auto-login the user
                    session()->set([
                        'admin_id' => $admin['id'],
                        'admin_employee_id' => $admin['employee_id'],
                        'admin_name' => $admin['employee_id'],
                        'admin_email' => $admin['email'],
                        'admin_logged_in' => true
                    ]);

                    return redirect()->to('/dashboard');
                }
            }
        }

        return view('auth/login');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            // Validate form inputs
            $validation = \Config\Services::validation();
            $validation->setRules([
                'employee_id' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('error', 'Please fill in all fields correctly.');
            }

            $employee = $this->request->getPost('employee_id');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $rememberMe = $this->request->getPost('remember_me');

            // Find admin by both employee_id and email for better security
            $admin = $this->adminModel->getAdminByCredentials($employee, $email);

            // Check if admin exists and password is correct
            if ($admin && password_verify($password, $admin['password'])) {
                $sessionData = [
                    'admin_id' => $admin['id'],
                    'admin_employee_id' => $admin['employee_id'],
                    'admin_name' => $admin['employee_id'],
                    'admin_email' => $admin['email'],
                    'admin_logged_in' => true
                ];

                session()->set($sessionData);

                // Handle Remember Me functionality
                if ($rememberMe) {
                    // Set longer session lifetime (30 days)
                    session()->setTempdata('admin_remember', true, 30 * 24 * 60 * 60);

                    // Set remember me cookie (30 days)
                    $cookieData = [
                        'admin_id' => $admin['id'],
                        'admin_employee_id' => $admin['employee_id'],
                        'admin_email' => $admin['email']
                    ];

                    setcookie('remember_admin', base64_encode(json_encode($cookieData)), time() + (30 * 24 * 60 * 60), '/', '', false, true);
                }

                return redirect()->to('/dashboard')->with('success', 'Login berhasil!');
            } else {
                // Generic error message for security (don't reveal which field is wrong)
                return redirect()->back()->withInput()->with('error', 'Invalid credentials. Please check your Employee ID, Email, and Password.');
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'POST') {
            log_message('info', 'Registration attempt started');

            $validation = \Config\Services::validation();
            $validation->setRules([
                'employee_id' => 'required|integer',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            try {
                $employeeId = $this->request->getPost('employee_id');
                $email = $this->request->getPost('email');

                // Step 1: Check if user credentials exist in external Artimu database
                $user = $this->artimuUserModel->validateUserCredentials($employeeId, $email);
                if (!$user) {
                    log_message('info', 'User credentials not found in Artimu database - ID: ' . $employeeId . ', Email: ' . $email);
                    return redirect()->back()->withInput()->with('error', 'USER CREDENTIALS NOT FOUND. The provided ID and Email combination do not exist in the system. Please contact your administrator.');
                }

                // Step 3: Check if this employee already has an admin account
                $existingAdmin = $this->adminModel->where('employee_id', $employeeId)->first();
                if ($existingAdmin) {
                    log_message('info', 'Employee already has admin account: ' . $employeeId);
                    return redirect()->back()->withInput()->with('error', 'ADMIN ACCOUNT ALREADY EXISTS for this employee ID.');
                }

                // Step 4: Check if email is already used by another admin
                $existingEmailAdmin = $this->adminModel->where('email', $email)->first();
                if ($existingEmailAdmin) {
                    log_message('info', 'Email already used by another admin: ' . $email);
                    return redirect()->back()->withInput()->with('error', 'EMAIL ALREADY USED by another admin account.');
                }

                // Step 5: Create admin account
                $data = [
                    'employee_id' => $employeeId,
                    'email' => $email,
                    'password' => $this->request->getPost('password')
                ];

                log_message('info', 'Attempting to create admin with data: ' . json_encode(array_merge($data, ['password' => '[HIDDEN]'])));

                if ($this->adminModel->createAdmin($data)) {
                    log_message('info', 'Admin created successfully');
                    // Beri pesan sukses dan tetap di halaman register
                    return redirect()->to('/auth/register')->with('success', 'ACCOUNT SUCCESSFULLY REGISTERED');
                } else {
                    log_message('error', 'Failed to create admin');
                    return redirect()->back()->withInput()->with('error', 'Failed to create admin account. Please try again.');
                }
            } catch (\Exception $e) {
                log_message('error', 'Registration exception: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Database error: ' . $e->getMessage());
            }
        }

        // Show register page
        return view('auth/register');
    }

    public function testdb()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query('SELECT 1 as test');
            $result = $query->getResult();

            echo "Database connection: OK<br>";
            echo "Test query result: " . json_encode($result) . "<br>";

            // Test admin table
            $adminCount = $db->table('admin')->countAllResults();
            echo "Admin table exists with {$adminCount} records<br>";
        } catch (\Exception $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public function testPromag()
    {
        try {
            echo "<h3>Testing Promag Database Connection</h3>";

            // Test Artimu database connection
            $user = $this->artimuUserModel->findById('9999999999');

            if ($user) {
                echo "<p style='color: green;'>✓ Artimu database connection: SUCCESSFUL</p>";
                echo "<p>Found user: {$user['fullname']} ({$user['email']})</p>";

                // Test user validation
                $validUser = $this->artimuUserModel->validateUserCredentials('9999999999', 'adminwru4@gmail.com');

                if ($validUser) {
                    echo "<p style='color: green;'>✓ User validation: SUCCESSFUL</p>";
                    echo "<p>Validated user: {$validUser['username']} - {$validUser['fullname']}</p>";
                } else {
                    echo "<p style='color: red;'>✗ User validation: FAILED</p>";
                }

                // Test invalid credentials
                $invalidUser = $this->artimuUserModel->validateUserCredentials('invalid', 'invalid@test.com');

                if (!$invalidUser) {
                    echo "<p style='color: green;'>✓ Invalid credentials properly rejected</p>";
                } else {
                    echo "<p style='color: red;'>✗ Invalid credentials incorrectly accepted</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Promag database connection: FAILED</p>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
            echo "<p>Stack trace: " . $e->getTraceAsString() . "</p>";
        }
    }

    public function logout()
    {
        // Clear remember me cookie if it exists
        if (isset($_COOKIE['remember_admin'])) {
            setcookie('remember_admin', '', time() - 3600, '/', '', false, true);
        }

        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Logout berhasil!');
    }
}
