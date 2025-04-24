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
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_kegiatan_id')
            ->constrained('paket_kegiatans')
            ->onDelete('restrict'); // ini yang penting
            $table->foreignId('vendor_id')
            ->constrained('vendors')
            ->onDelete('restrict'); // ini yang penting
            $table->double('nilai')->nullable();
            $table->date('batas_akhir');
            $table->string('penawaran_st')->default('PENAWARAN_ST_01')->nullable();
            $table->string('surat_undangan')->nullable();
            $table->string('bukti_setor_pajak')->nullable();
            $table->string('dok_penawaran')->nullable();
            $table->date('tanggal_upload_dok')->nullable();
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawarans');
    }
};
