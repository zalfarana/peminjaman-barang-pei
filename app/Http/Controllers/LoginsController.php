<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginsController extends Controller
{
    public function index()
    {
        return view('login');
    }
    
    public function login(Request $request)
    {
        $cek = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($cek)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Maaf! Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }
}
