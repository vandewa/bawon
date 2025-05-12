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
        Schema::table('paket_pekerjaan_rincis', function (Blueprint $table) {
            $table->boolean('use_st')->default(false)->after('anggaran_stlh_pak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_pekerjaan_rincis', function (Blueprint $table) {
            $table->dropColumn('use_st');
        });
    }
};
