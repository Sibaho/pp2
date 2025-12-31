<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Timpp2;
use Illuminate\Support\Str;

class AsetController extends Controller
{
    public function index()
    {
        $asets = Aset::orderBy('created_at', 'desc')->get();
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);

        if ($guard === 'timpp2') {
            return view('aset.timpp2-aset-index', compact('asets', 'profileData'));
        }

        return view('aset.admin-aset-index', compact('asets', 'profileData'));
    }

    public function add()
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);
        if ($guard === 'timpp2') {
            return view('aset.timpp2-aset-add', compact('profileData'));
        }
        return view('aset.aset-add', compact('profileData'));
    }

    public function store(Request $request)
    {
        // 1. Validasi dasar (tanpa unique dulu)
        $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi_aset' => 'required|string|max:255',
            'status_aset' => 'required|string|max:100',
            'kode_aset' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Cek manual: kode_aset sudah ada?
        if (Aset::where('kode_aset', $request->kode_aset)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with([
                    'message' => 'Kode aset sudah digunakan',
                    'alert-type' => 'error'
                ]);
        }

        // 3. Simpan ke database
        Aset::create([
            'uuid' => Str::uuid(),
            'nama_aset' => $request->nama_aset,
            'lokasi_aset' => $request->lokasi_aset,
            'status_aset' => $request->status_aset,
            'kode_aset' => $request->kode_aset,
            'deskripsi' => $request->deskripsi,
        ]);

        if (Auth::guard('admin')->check()) {
            $route = 'admin.asets.index';
        } else {
            $route = 'timpp2.asets.index';
        }
        // 4. Notifikasi sukses
        return redirect()->route($route)->with([
            'message' => 'Aset added successfully',
            'alert-type' => 'success'
        ]);
    }


    public function edit($uuid)
    {
        $guard = Auth::guard('admin')->check() ? 'admin' : 'timpp2';
        $id = Auth::guard($guard)->user()->id;
        $profileData = $guard === 'admin'
            ? Admin::find($id)
            : Timpp2::find($id);
        $aset = Aset::where('uuid', $uuid)->firstOrFail();
        if ($guard === 'timpp2') {
            return view('aset.timpp2-aset-edit', compact('aset', 'profileData'));
        }
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

        if (Auth::guard('admin')->check()) {
            $route = 'admin.asets.index';
        } else {
            $route = 'timpp2.asets.index';
        }
        return redirect()->route($route)->with('success', 'Aset updated successfully.');
    }

    public function delete($uuid)
    {
        $aset = Aset::where('uuid', $uuid)->firstOrFail();
        $aset->delete();

        return redirect()->route('admin.asets.index')->with('success', 'Aset deleted successfully.');
    }
}
