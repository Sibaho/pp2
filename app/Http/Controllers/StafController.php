<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aset;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StafController extends Controller
{
    public function dashboard()
    {
          $id = Auth::guard('web')->user()->id;
        $profileData = User::find($id);
        $aktifCount = Monitoring::where('aktif', 'aktif')->count();
        $selesaiCount = Monitoring::where('aktif', 'selesai')->count();
        $monitorings = Monitoring::dueWithinDays(7)->get();
        $idleAsetCount = Aset::where('status_aset', 'Idle')->count();
        $optimizedAsetCount = Aset::where('status_aset', 'Optimized')->count();

        return view('staff.dashboard', compact('profileData', 'aktifCount', 'selesaiCount', 'monitorings', 'idleAsetCount', 'optimizedAsetCount'));
    }

    // public function profile()
    // {
    //     // Logic to retrieve and display staff profile
    //     return view('staff.profile');
    // }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
