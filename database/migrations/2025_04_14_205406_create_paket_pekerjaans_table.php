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
        Schema::create('paket_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')
            ->constrained('desas')
            ->onDelete('restrict'); // ini yang penting
            $table->integer('tahun');
            $table->string('kd_desa');
            $table->string('kd_keg');
            $table->string('sumberdana')->nullable();
            $table->string('nama_kegiatan');
            $table->double('nilaipak')->nullable();
            $table->string('satuan')->nullable();
            $table->double('pagu_pak')->nullable();
            $table->string('nm_pptkd')->nullable();
            $table->string('jbt_pptkd')->nullable();
            $table->string('nama_bidang');
            $table->string('nama_subbidang');
            $table->string('kegiatan_st')->default('KEGIATAN_ST_01');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_pekerjaans');
    }
};
