<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->date('masa_berlaku_nib')->nullable();
            $table->string('instansi_pemberi_nib')->nullable();
            $table->string('website')->nullable();
            $table->string('bank_st')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('atas_nama_rekening')->nullable();
            $table->string('dok_kebenaran_usaha_file')->nullable();
            $table->string('bukti_setor_pajak_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
        });
    }
};
