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
        Schema::create('aparaturs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')
            ->constrained('desas')
            ->onDelete('cascade'); // ini yang penting
            $table->string('nama');
            $table->string('nik');
            $table->string('jabatan');
            $table->string('bidang');
            $table->string('alamat');
            $table->string('telp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tmt_awal');
            $table->date('tmt_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aparaturs');
    }
};
