<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Monitoring extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = [
        'tanggal_awal_prj',
        'tanggal_akhir_prf',
        'tanggal_tenggat_waktu_permohonan_perpanjangan',
        'reminder_prj_berakhir',
        'dua_bulan_pengawasan',
        'due_date',
    ];

    /**
     * Ambil monitoring yang tanggal_akhir_prf jatuh dalam X hari dari hari ini (inklusive hari ini).
     *
     * @param Builder $query
     * @param int $days
     * @return Builder
     */
    public function scopeDueWithinDays(Builder $query, int $days)
    {
        $today = Carbon::now('Asia/Jakarta')->startOfDay()->toDateString();
        $limit = Carbon::now('Asia/Jakarta')->startOfDay()->addDays($days)->toDateString();

        return $query->whereNotNull('tanggal_akhir_prf')
            ->whereBetween('tanggal_akhir_prf', [$today, $limit])
            ->orderBy('tanggal_akhir_prf', 'asc');
    }

    /**
     * Ambil monitoring yang sudah overdue (tanggal_akhir_prf < hari ini).
     *
     * @param Builder $query
     * @param bool $includeToday jika true, masukkan yang berakhir hari ini sebagai overdue (<=)
     * @return Builder
     */
    public function scopeOverdue(Builder $query, bool $includeToday = false)
    {
        $today = Carbon::now('Asia/Jakarta')->startOfDay()->toDateString();

        return $includeToday
            ? $query->whereNotNull('tanggal_akhir_prf')->whereDate('tanggal_akhir_prf', '<=', $today)->orderBy('tanggal_akhir_prf', 'asc')
            : $query->whereNotNull('tanggal_akhir_prf')->whereDate('tanggal_akhir_prf', '<', $today)->orderBy('tanggal_akhir_prf', 'asc');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }
}
