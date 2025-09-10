<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\PromagUserModel;

class TestPromagConnection extends BaseCommand
{
    /**
     * The Command's Group
     */
    protected $group = 'App';

    /**
     * The Command's Name
     */
    protected $name = 'test:promag';

    /**
     * The Command's Description
     */
    protected $description = 'Test Promag database connection and user validation';

    /**
     * The Command's Usage
     */
    protected $usage = 'test:promag';

    /**
     * The Command's Arguments
     */
    protected $arguments = [];

    /**
     * The Command's Options
     */
    protected $options = [];

    /**
     * Actually execute a command.
     */
    public function run(array $params)
    {
        try {
            CLI::write('Testing Promag database connection...', 'green');
            
            $promagUserModel = new PromagUserModel();
            
            // Test connection by counting users
            $userCount = $promagUserModel->countAllResults();
            CLI::write("Total users in Promag database: {$userCount}", 'yellow');
            
            // Test specific user validation from the provided sample data
            $testUserId = '9999999999';
            $testEmail = 'adminwru4@gmail.com';
            
            CLI::write("Testing user validation with ID: {$testUserId} and Email: {$testEmail}", 'cyan');
            
            $user = $promagUserModel->validateUserCredentials($testUserId, $testEmail);
            
            if ($user) {
                CLI::write("✓ User validation SUCCESSFUL", 'green');
                CLI::write("  - User ID: {$user['id']}", 'white');
                CLI::write("  - Username: {$user['username']}", 'white');
                CLI::write("  - Full Name: {$user['fullname']}", 'white');
                CLI::write("  - Email: {$user['email']}", 'white');
            } else {
                CLI::write("✗ User validation FAILED", 'red');
            }
            
            // Test another user from sample data
            $testUserId2 = '1000000001';
            $testEmail2 = 'dputra@wru.local';
            
            CLI::write("Testing another user with ID: {$testUserId2} and Email: {$testEmail2}", 'cyan');
            
            $user2 = $promagUserModel->validateUserCredentials($testUserId2, $testEmail2);
            
            if ($user2) {
                CLI::write("✓ Second user validation SUCCESSFUL", 'green');
                CLI::write("  - User ID: {$user2['id']}", 'white');
                CLI::write("  - Username: {$user2['username']}", 'white');
                CLI::write("  - Full Name: {$user2['fullname']}", 'white');
                CLI::write("  - Email: {$user2['email']}", 'white');
            } else {
                CLI::write("✗ Second user validation FAILED", 'red');
            }
            
            // Test invalid credentials
            CLI::write("Testing invalid credentials...", 'cyan');
            $invalidUser = $promagUserModel->validateUserCredentials('999999', 'invalid@email.com');
            
            if (!$invalidUser) {
                CLI::write("✓ Invalid credentials correctly rejected", 'green');
            } else {
                CLI::write("✗ Invalid credentials incorrectly accepted", 'red');
            }
            
            CLI::write("Promag database test completed!", 'green');
            
        } catch (\Exception $e) {
            CLI::write('Error: ' . $e->getMessage(), 'red');
            CLI::write('Stack trace: ' . $e->getTraceAsString(), 'red');
        }
    }
}