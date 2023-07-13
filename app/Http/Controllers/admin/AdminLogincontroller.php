<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AdminLogincontroller extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' =>
            $request->password], $request->get('remember'))) {

                $admin = Auth::guard('admin')->user();

                if ($admin->status == 2) {
                    return Redirect::route('admin.dashboard');
                } else {
                    return Redirect()->route('admin.login')->with('error', 'Either Email/Password is invalid');
                }

                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::back()->with('error', 'Either Email/Password is invalid');
                // return Redirect::back()->with('success', 'Either Email/Password is invalid');
                // return Redirect()->route('admin.login')->with('error', 'Either Email/Password is invalid');
            }
        } else {
            return Redirect::back()->withErrors($validator)->withInput($request->only('email'));
            // return redirect()->route('admin.login')
            //     ->withErrors($validator)
            //     ->withInput($request->only('email'));
        }
    }
}
