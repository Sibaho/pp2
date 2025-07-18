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
            return view('monitoring.admin-monitoring-index', compact('profileData', 'monitoringData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Timpp2::find($id);
            return view('monitoring.timpp2-monitoring-index', compact('profileData'));
        }
    }

    public function add()
    {
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($id);
            return view('monitoring.admin-monitoring-add', compact('profileData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Timpp2::find($id);
            return view('monitoring.timpp2-monitoring-add', compact('profileData'));
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

    public function edit($id)
    {
        
        if (Auth::guard('admin')->check()) {
            $userId = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($userId);
            $monitoringData = Monitoring::findOrFail($id);
            return view('monitoring.admin-monitoring-edit', compact('monitoringData', 'profileData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $monitoringData = Monitoring::findOrFail($id);
            return view('monitoring.timpp2-monitoring-edit', compact('monitoringData'));
        }
    }

    public function update(Request $request, $id)
    {
        $monitoringData = Monitoring::findOrFail($id);
        $monitoringData->update($request->all());
        $notification = [
            'message' => 'Monitoring updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.monitoring.index')->with($notification);
    }
}
