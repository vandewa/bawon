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
        Schema::table('tpks', function (Blueprint $table) {
            // Ganti nama kolom dari 'tim_type' ke 'tim_id'
            $table->renameColumn('tim_type', 'tim_id');

            // Hapus kolom 'tahun'
            $table->dropColumn('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tpks', function (Blueprint $table) {
            //
        });
    }
};
