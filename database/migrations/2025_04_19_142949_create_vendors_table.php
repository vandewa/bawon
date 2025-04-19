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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('nib')->unique();
            $table->string('npwp')->nullable();
            $table->string('alamat');
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('nama_direktur');
            $table->string('jenis_usaha')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('kualifikasi')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kode_pos')->nullable();

            // Dokumen legalitas
            $table->string('akta_pendirian')->nullable();
            $table->string('nib_file')->nullable();
            $table->string('npwp_file')->nullable();
            $table->string('siup')->nullable();
            $table->string('izin_usaha_lain')->nullable();
            $table->string('ktp_direktur')->nullable();
            $table->string('rekening_perusahaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
