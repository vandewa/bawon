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
        Schema::create('kaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pekerjaan_id')
            ->constrained('paket_pekerjaans')
            ->onDelete('restrict'); // ini yang penting
            $table->longText('latar_belakang')->nullable();
            $table->longText('tujuan')->nullable();
            $table->longText('sasaran')->nullable();
            $table->longText('lokasi')->nullable();
            $table->longText('sumber_pendanaan')->nullable();
            $table->longText('nilai_pekerjaan')->nullable();
            $table->longText('kode_rekening')->nullable();
            $table->foreignId('aparatur_id')
            ->constrained('aparaturs')
            ->onDelete('cascade'); // ini yang penting
            $table->longText('tpk')->nullable();
            $table->longText('lingkup_pekerjaan')->nullable();
            $table->longText('spek_teknis')->nullable();
            $table->longText('peralatan_material')->nullable();
            $table->longText('jangka_waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaks');
    }
};
