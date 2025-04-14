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
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->string('kabupaten')->default('Wonosobo');
            $table->string('kode_desa');
            $table->string('kecamatan_id');
            $table->string('name');
            $table->string('kode_pos')->nullable();
            $table->string('alamat')->nullable();
            $table->string('web')->nullable();
            $table->string('email')->nullable();
            $table->string('telp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};
