<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('no_prj');
            $table->string('dl')->nullable();
            $table->string('tahun')->nullable();
            $table->string('mitra')->nullable();
            $table->string('cp_mitra')->nullable();
            $table->string('lokasi_aset')->nullable();
            $table->string('aset')->nullable();
            $table->date('tanggal_awal_prj')->nullable();
            $table->date('tanggal_akhir_prf')->nullable();
            $table->date('tanggal_tenggat_waktu_permohonan_perpanjangan')->nullable();
            $table->date('reminder_prj_berakhir')->nullable();
            $table->date('dua_bulan_pengawasan')->nullable();
            $table->string('aktif')->nullable();
            $table->string('due_date_invoice')->nullable();
            $table->string('due_date_pembayaran_sewa_guna')->nullable();
            $table->date('due_date')->nullable();
            $table->string('reminder')->nullable();
            $table->string('jumlah_bayar')->nullable();
            $table->string('pic')->nullable();
            $table->string('pending_issue')->nullable();
            $table->text('pembayaran_pbb')->nullable();
            $table->boolean('arsip_prj')->nullable();
            $table->boolean('penilaian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitorings');
    }
};
