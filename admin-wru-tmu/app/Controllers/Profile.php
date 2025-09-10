<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Profile extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
    public function index()
    {
        $adminId = session()->get('admin_id');
        $admin = (new AdminModel())->find($adminId);
        return view('profile/index', ['admin' => $admin]);
    }

    
}