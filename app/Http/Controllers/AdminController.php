<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function managefacility()
    {
        return view('admin.managefacility');
    }

    public function managestaff()
    {
        return view('admin.managestaff');
    }   

    public function report()
    {
        return view('admin.report');
    }
}


