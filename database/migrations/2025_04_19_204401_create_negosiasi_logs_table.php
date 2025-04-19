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
        Schema::create('negosiasi_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negoisasi_id')
            ->constrained('negoisasis')
            ->onDelete('restrict'); // ini yang penting
            $table->double('penawaran');
            $table->longText('keterangan')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negosiasi_logs');
    }
};
