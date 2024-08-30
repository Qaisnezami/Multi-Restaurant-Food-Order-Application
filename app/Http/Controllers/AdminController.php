<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin_login(){
        return view('admin.login');
    }

    public function admin_dashboard(){
        return view('admin.dashboard');
    }


    public function admin_login_submit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credentials)){
            return redirect()->route('admin.dashboard')
                        ->with('success','You are successfully logged in');
        }else{
            return redirect()->route('admin.login')
                        ->with('error','Email and Password are wrong.');
        }


    }

    public function admin_logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')
                        ->with('success','You are successfully logged out');
    }
}
