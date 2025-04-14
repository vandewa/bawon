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
        Schema::create('pkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')
            ->constrained('desas')
            ->onDelete('cascade'); // ini yang penting
            $table->foreignId('aparatur_id')
            ->constrained('aparaturs')
            ->onDelete('cascade'); // ini yang penting
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkas');
    }
};
