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
        Schema::table('paket_kegiatan_rincis', function (Blueprint $table) {
            $table->integer('quantity')->after('paket_pekerjaan_rinci_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_kegiatan_rincis', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
