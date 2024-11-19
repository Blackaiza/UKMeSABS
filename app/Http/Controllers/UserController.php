<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function booking()
    {
        return view('user.booking');
    }

    public function history()
    {
        return view('user.history');
    }   
}