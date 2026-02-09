<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::guard('timpp2')->check()) {
                return redirect()->route('timpp2.dashboard');
            } elseif (Auth::guard('web')->check()) {
                return redirect()->route('staff.dashboard');
            }
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'You are successfully logged in');
        }
        // Login sebagai TIMPP2
        if (Auth::guard('timpp2')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('timpp2.dashboard')
                ->with('success', 'You are successfully logged in');
        }

        // Login sebagai STAFF
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('staff.dashboard')
                ->with('success', 'You are successfully logged in');
        }

        return back()->with([
            'message' => 'Email atau password salah.',
            'alert-type' => 'error',
        ]);
    }
}
