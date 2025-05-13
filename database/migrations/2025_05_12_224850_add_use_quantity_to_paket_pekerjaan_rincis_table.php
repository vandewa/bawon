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
            $table->integer('quantity')->nullable()->after('use_st');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paket_pekerjaan_rincis', function (Blueprint $table) {
            //
        });
    }
};
