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
        Schema::table('paket_kegiatans', function (Blueprint $table) {
             $table->string('bukti_bayar')->nullable()->after('ba_evaluasi_penawaran');
            $table->string('ba_pemenang')->nullable()->after('ba_evaluasi_penawaran');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_kegiatans', function (Blueprint $table) {
            //
        });
    }
};
