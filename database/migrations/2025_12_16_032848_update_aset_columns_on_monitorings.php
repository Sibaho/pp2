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
         Schema::table('monitorings', function (Blueprint $table) {
            // add new column
            $table->unsignedBigInteger('aset_id')->after('id');

            // drop old columns
            $table->dropColumn(['lokasi_aset', 'aset']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('monitorings', function (Blueprint $table) {
            // restore dropped columns
            $table->string('lokasi_aset')->nullable();
            $table->string('aset')->nullable();

            // remove aset_id
            $table->dropColumn('aset_id');
        });
    }
};
