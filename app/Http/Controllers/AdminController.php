<?php

namespace App\Http\Controllers;

use App\Mail\AdminForgotPassword;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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


    public function admin_forgot_password(){
        return view('admin.forgot-password');
    }

    public function admin_forgot_password_submit(Request $request){
        $request->validate(['email' => 'required|email']);
        
        $admin = Admin::where('email', $request->email)->first();
        if(!$admin){
            return redirect()->back()
                    ->with('error','Email does not exist');
        }

        $token = Hash('sha256', time());
        $admin->token = $token;
        $admin->save();

        $url = route('admin.reset.password', ['token' => $token,'email' => $request->email]);
        $subject = 'Reset Password';
        $body = 'Hello,'.$admin->name.'<br>';
        $body .= 'Click on the link below to reset your password';

        Mail::to($request->email)->send(new AdminForgotPassword($subject, $body, $url));

        return redirect()->back()
                    ->with('success','Reset password link has been sent to your email');





        
    }


    public function admin_reset_password($token, $email){
        $admin = Admin::where(['email'=>$email, 'token'=>$token])->first();
        if(!$admin){
            return redirect()->route('admin.login')
                    ->with('error','Invalid token');
        }

        return view('admin.reset-password', compact('token','email'));

    }


    public function admin_reset_password_submit(Request $request){
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'token' => 'required'
        ]);

        Admin::where(['email'=>$request->email, 'token'=>$request->token])
                ->update(['password'=>Hash::make($request->password), 'token'=>null]);
        
        return redirect()->route('admin.login')
                    ->with('success','Password has been reset successfully');

    
    }
}
