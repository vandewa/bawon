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
        Schema::create('evaluasi_penawarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained()->onDelete('cascade');
            // Evaluasi Administrasi
            $table->boolean('surat_kebenaran_ada')->nullable();
            $table->string('surat_kebenaran_hasil')->nullable();

            // Evaluasi Teknis
            $table->boolean('spesifikasi_ada')->nullable();
            $table->string('spesifikasi_hasil')->nullable();

            $table->boolean('jadwal_ada')->nullable();
            $table->string('jadwal_hasil')->nullable();

            // Evaluasi Harga
            $table->boolean('harga_ada')->nullable();
            $table->string('harga_hasil')->nullable(); // ex: "lulus", "tidak lulus", "95% dari HPS"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_penawarans');
    }
};
