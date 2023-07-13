<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class adminHomeController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // echo 'Hello World ' . $admin->name . ' <a href="' . route('admin.logout') . '">Logout</a>';
        // return view('admin.dashboard' , compact('admin'));
        // return view and send data to view
        return view('admin.dashboard')->with('admin', $admin);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return Redirect::route('admin.login');
    }
}
