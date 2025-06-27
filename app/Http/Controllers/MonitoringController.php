<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Monitoring;
use App\Models\Timpp2;

class MonitoringController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($id);
            $monitoringData = Monitoring::latest()->get();
            return view('monitoring.index-admin', compact('profileData', 'monitoringData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Timpp2::find($id);
            return view('monitoring.index-timpp2', compact('profileData'));
        }
    }

    public function add()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($id);
            return view('monitoring.monitoring-add-admin', compact('profileData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Timpp2::find($id);
            return view('monitoring.monitoring-add-timpp2', compact('profileData'));
        }
    }

    public function store(Request $request)
    {
       

        Monitoring::create($request->all());
        $notification = [
            'message' => 'Monitoring created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }
}
