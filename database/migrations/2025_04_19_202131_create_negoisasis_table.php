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
        Schema::create('negoisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_kegiatan_id')
            ->constrained('paket_kegiatans')
            ->onDelete('restrict'); // ini yang penting
            $table->foreignId('vendor_id')
            ->constrained('vendors')
            ->onDelete('restrict'); // ini yang penting
            $table->double('nilai')->nullable();
            $table->string('negosiasi_st')->nullable();
            $table->string('ba_negoisasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negoisasis');
    }
};
