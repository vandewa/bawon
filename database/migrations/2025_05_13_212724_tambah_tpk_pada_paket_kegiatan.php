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
        Schema::table('paket_kegiatans', function (Blueprint $table) {
            $table->unsignedBigInteger('tpk_id')->nullable()->after('id'); // atau after kolom yang sesuai
            $table->foreign('tpk_id')
                  ->references('id')->on('tpks')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['tpk_id']);
            $table->dropColumn('tpk_id');
        });
    }
};
