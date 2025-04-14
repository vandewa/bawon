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
        Schema::create('spek_teknis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pekerjaan_id')
            ->constrained('paket_pekerjaans')
            ->onDelete('restrict'); // ini yang penting
            $table->longText('deskripsi');
            $table->string('volume')->nullable();
            $table->string('satuan')->nullable();
            $table->longText('spesifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spek_teknis');
    }
};
