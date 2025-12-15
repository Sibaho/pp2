<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Timpp2;

class AsetController extends Controller
{
    public function index()
    {
        $asets = Aset::all();
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);

        return view('aset.admin-aset-index', compact('asets', 'profileData'));
    }

    public function add()
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);
        return view('aset.aset-add', compact('profileData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi_aset' => 'required|string|max:255',
            'status_aset' => 'required|string|max:100',
            'kode_aset' => 'required|string|max:100|unique:asets,kode_aset',
            'deskripsi' => 'nullable|string',
        ]);
        $request->merge(['uuid' => \Illuminate\Support\Str::uuid()]);

        Aset::create($request->all());

        $notification = [
            'message' => 'Aset added successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.asets.index')->with($notification);
    }

    public function edit($uuid)
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);
        $aset = Aset::where('uuid', $uuid)->firstOrFail();
        return view('aset.aset-edit', compact('aset', 'profileData'));
    }

    public function update(Request $request, $uuid)
    {
        $aset = Aset::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi_aset' => 'required|string|max:255',
            'status_aset' => 'required|string|max:100',
            'kode_aset' => 'required|string|max:100|unique:asets,kode_aset,' . $aset->id,
            'deskripsi' => 'nullable|string',
        ]);

        $aset->update($request->all());

        return redirect()->route('admin.asets.index')->with('success', 'Aset updated successfully.');
    }

    public function delete($uuid)
    {
        $aset = Aset::where('uuid', $uuid)->firstOrFail();
        $aset->delete();

        return redirect()->route('admin.asets.index')->with('success', 'Aset deleted successfully.');
    }
}
