<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Aset;
use App\Models\Monitoring;
use App\Models\Timpp2;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitoringData = Monitoring::with('aset')->get();
        if (Auth::guard('admin')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($id);
            return view('monitoring.admin-monitoring-index', compact('profileData', 'monitoringData'));
        }
        if (Auth::guard('timpp2')->check()) {
            $id = Auth::guard('admin')->user()->id;
            $profileData = Timpp2::find($id);
            return view('monitoring.timpp2-monitoring-index', compact('profileData', 'monitoringData'));
        }
    }

    public function add()
    {
        $asets = Aset::all();    
        if (Auth::guard('admin')->check()) {
            $profileData = Auth::guard('admin')->user();
            return view('monitoring.admin-monitoring-add', compact('profileData', 'asets'));
        }

        if (Auth::guard('timpp2')->check()) {
            $profileData = Auth::guard('timpp2')->user();
            return view('monitoring.timpp2-monitoring-add', compact('profileData', 'asets'));
        }
    }

    public function store(Request $request)
    {
        $request->merge(['uuid' => \Illuminate\Support\Str::uuid()]);
        Monitoring::create($request->all());

        $notification = [
            'message' => 'Monitoring created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function edit($uuid)
    {
        $monitoringData = Monitoring::with('aset')->where('uuid', $uuid)->firstOrFail();
        $asets = Aset::all();
        if (Auth::guard('admin')->check()) {
            $userId = Auth::guard('admin')->user()->id;
            $profileData = Admin::find($userId);

            return view('monitoring.admin-monitoring-edit', compact('monitoringData', 'profileData', 'asets'));
        }
        if (Auth::guard('timpp2')->check()) {

            return view('monitoring.timpp2-monitoring-edit', compact('monitoringData', 'profileData', 'asets'));
        }
    }

    public function update(Request $request, $uuid)
    {
        // dd($request->all());
        $monitoringData = Monitoring::where('uuid', $uuid)->firstOrFail();
        $monitoringData->update($request->all());
        $notification = [
            'message' => 'Monitoring updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.monitoring.index')->with($notification);
    }
}
