<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\EmployeeModel;

class TestEmployeeTable extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'test:employee';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Test employee table and data';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'test:employee';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $employeeModel = new EmployeeModel();
        
        try {
            CLI::write('Testing employee table...', 'green');
            
            // Count employees
            $count = $employeeModel->countAllResults();
            CLI::write("Total employees: {$count}", 'yellow');
            
            // Get all employees
            $employees = $employeeModel->findAll();
            
            CLI::write('Employee data:', 'cyan');
            foreach ($employees as $employee) {
                CLI::write("- Employee ID: {$employee['employee_id']}, Email: {$employee['email']}", 'white');
            }
            
            // Test specific employee lookup
            $testEmployee = $employeeModel->findByEmployeeId(2025001);
            if ($testEmployee) {
                CLI::write("Test lookup for Employee ID 2025001: SUCCESS", 'green');
                CLI::write("Email: {$testEmployee['email']}", 'white');
            } else {
                CLI::write("Test lookup for Employee ID 2025001: FAILED", 'red');
            }
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
        }
    }
}
