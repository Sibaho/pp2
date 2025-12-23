<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Aset;
use App\Models\Monitoring;
use App\Models\Timpp2;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
        // 1. Validasi
        $request->validate([
            'dokumen_perjanjian' => 'required|file|mimes:pdf|max:20480', // 20 MB
        ]);

        // 2. Generate UUID untuk data
        $uuid = Str::uuid();

        // 3. Simpan file ke storage/app/public/dokumen_perjanjian
        $file = $request->file('dokumen_perjanjian');
        $filename = $uuid . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'dokumen_perjanjian',
            $filename,
            'public'
        );

        // 4. Simpan ke database
        Monitoring::create([
            'uuid' => $uuid,
            'aset_id' => $request->aset_id,
            'dokumen_perjanjian' => $path,
            'no_prj' => $request->no_prj,
            'tahun' => $request->tahun,
            'mitra' => $request->mitra,
            'cp_mitra' => $request->cp_mitra,
            'tanggal_akhir_prf' => $request->tanggal_akhir_prf,
            'tanggal_awal_prj' => $request->tanggal_awal_prj,
            'tanggal_tenggat_waktu_permohonan_perpanjangan' => $request->tanggal_tenggat_waktu_permohonan_perpanjangan,
            'reminder_prj_berakhir' => $request->reminder_prj_berakhir,
            'dua_bulan_pengawasan' => $request->dua_bulan_pengawasan,
            'aktif' => $request->aktif,
            'due_date_invoice' => $request->due_date_invoice,
            'due_date_pembayaran_sewa_guna' => $request->due_date_pembayaran_sewa_guna,
            'due_date' => $request->due_date,
            'reminder' => $request->reminder,
            'jumlah_bayar' => $request->jumlah_bayar,
            'pic' => $request->pic,
            'pending_issue' => $request->pending_issue,
            'pembayaran_pbb' => $request->pembayaran_pbb,
            'arsip_prj' => $request->arsip_prj,
            'penilaian' => $request->penilaian,
        ]);

        // 4. Notifikasi
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
        // 1. Ambil data lama
        $monitoring = Monitoring::where('uuid', $uuid)->firstOrFail();

        // 2. Validasi (file OPTIONAL)
        $request->validate([
            'dokumen_perjanjian' => 'nullable|file|mimes:pdf|max:20480', // 20 MB
        ]);

        // 3. Default: pakai file lama
        $path = $monitoring->dokumen_perjanjian;

        // 4. Jika upload file baru
        if ($request->hasFile('dokumen_perjanjian')) {

            // Hapus file lama (jika ada)
            if ($monitoring->dokumen_perjanjian && Storage::disk('public')->exists($monitoring->dokumen_perjanjian)) {
                Storage::disk('public')->delete($monitoring->dokumen_perjanjian);
            }

            // Simpan file baru
            $file = $request->file('dokumen_perjanjian');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs(
                'dokumen_perjanjian',
                $filename,
                'public'
            );
        }

        // 5. Update database
        $monitoring->update([
            'dokumen_perjanjian' => $path,
            'aset_id' => $request->aset_id,
            'no_prj' => $request->no_prj,
            'tahun' => $request->tahun,
            'mitra' => $request->mitra,
            'cp_mitra' => $request->cp_mitra,
            'tanggal_akhir_prf' => $request->tanggal_akhir_prf,
            'tanggal_awal_prj' => $request->tanggal_awal_prj,
            'tanggal_tenggat_waktu_permohonan_perpanjangan' => $request->tanggal_tenggat_waktu_permohonan_perpanjangan,
            'reminder_prj_berakhir' => $request->reminder_prj_berakhir,
            'dua_bulan_pengawasan' => $request->dua_bulan_pengawasan,
            'aktif' => $request->aktif,
            'due_date_invoice' => $request->due_date_invoice,
            'due_date_pembayaran_sewa_guna' => $request->due_date_pembayaran_sewa_guna,
            'due_date' => $request->due_date,
            'reminder' => $request->reminder,
            'jumlah_bayar' => $request->jumlah_bayar,
            'pic' => $request->pic,
            'pending_issue' => $request->pending_issue,
            'pembayaran_pbb' => $request->pembayaran_pbb,
            'arsip_prj' => $request->arsip_prj,
            'penilaian' => $request->penilaian,
        ]);

        return redirect()->back()->with([
            'message' => 'Monitoring updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function downloadDokumen($uuid)
    {
        // 1. Ambil data monitoring
        $monitoring = Monitoring::where('uuid', $uuid)->firstOrFail();

        // 2. Ambil path dari database
        $path = $monitoring->dokumen_perjanjian;

        // 3. Validasi path
        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        // 4. Download / Preview
        return response()->download(Storage::disk('public')->path($path));
        // Untuk preview di tab baru:
        // return Storage::disk('public')->response($path);
    }

    public function previewDokumen($uuid)
    {
        $monitoring = Monitoring::where('uuid', $uuid)->firstOrFail();
        $path = $monitoring->dokumen_perjanjian;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(
            Storage::disk('public')->path($path),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
            ]
        );
    }
}
