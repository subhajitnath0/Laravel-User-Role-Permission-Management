<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class loginController extends Controller
{

    public function index()
    {
        Auth::logout();
        return view('public.login');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->remember != null ? true : false;
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect(route('dashboard'))->with(["status" => 'success', 'message' => "Login Successful"]);
        } else {
            return redirect(route('login'))->with(['error' => 'error', 'alert-message'=>'Email or password is incorrect', 'email' => $request->email]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
