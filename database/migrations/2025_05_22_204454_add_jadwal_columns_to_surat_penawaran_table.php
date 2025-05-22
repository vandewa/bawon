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
        Schema::table('surat_penawaran', function (Blueprint $table) {
            $table->dateTime('tgl_pemasukan')->nullable()->after('paket_kegiatan_id'); // Atur posisi sesuai kebutuhan
            $table->dateTime('tgl_evaluasi')->nullable()->after('tgl_pemasukan');
            $table->dateTime('tgl_negosiasi')->nullable()->after('tgl_evaluasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_penawaran', function (Blueprint $table) {
            //
        });
    }
};
