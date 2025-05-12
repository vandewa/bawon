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
        Schema::create('paket_kegiatan_rincis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_kegiatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('paket_pekerjaan_rinci_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_kegiatan_rincis');
    }
};
