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
        Schema::create('paket_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pekerjaan_id')
            ->constrained('paket_pekerjaans')
            ->onDelete('restrict'); // ini yang penting
            $table->string('paket_type');
            $table->string('paket_kegiatan')->default('PAKET_KEGIATAN_ST_01');
            $table->double('jumlah_anggaran');
            $table->double('nilai_kesepakatan')->nullable();
            $table->string('spek_teknis')->nullable();
            $table->string('kak')->nullable();
            $table->string('jadwal_pelaksanaan')->nullable();
            $table->string('rencana_kerja')->nullable();
            $table->string('hps')->nullable();
            $table->string('ba_evaluasi_penawaran')->nullable();
            $table->string('spk')->nullable();
            $table->string(' ')->nullable();
            $table->string('laporan_hasil_pemeriksaan')->nullable();
            $table->string('bast_penyedia')->nullable();
            $table->string('bast_kades')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_kegiatans');
    }
};
