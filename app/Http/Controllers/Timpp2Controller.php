<?php

namespace App\Http\Controllers;

use App\Models\Timpp2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aset;
use App\Models\Monitoring;

class Timpp2Controller extends Controller
{
    public function login()
    {
        if (Auth::guard('timpp2')->check()) {
            return redirect()->route('timpp2.dashboard');
        }
        return view('timpp2.login');
    }


    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $check = $request->all();
        $credentials = [
            'email' => $check['email'],
            'password' => $check['password']
        ];

        if (Auth::guard('timpp2')->attempt($credentials)) {
            return redirect()->route('timpp2.dashboard')->with('success', 'You are successfully logged in');
        }
        return back()->withErrors([
            'errors' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        $id = Auth::guard('timpp2')->user()->id;
        $profileData = Timpp2::find($id);
        $aktifCount = Monitoring::where('aktif', 'aktif')->count();
        $selesaiCount = Monitoring::where('aktif', 'selesai')->count();
        $monitorings = Monitoring::dueWithinDays(7)->get();
        $idleAsetCount = Aset::where('status_aset', 'Idle')->count();
        $optimizedAsetCount = Aset::where('status_aset', 'Optimized')->count();
        return view('timpp2/dashboard', compact('profileData', 'aktifCount', 'selesaiCount', 'monitorings', 'idleAsetCount', 'optimizedAsetCount'));
    }

    public function logout()
    {
        Auth::guard('timpp2')->logout();
        return redirect()->route('login')->with('success', 'You are successfully logged out');
    }
}
