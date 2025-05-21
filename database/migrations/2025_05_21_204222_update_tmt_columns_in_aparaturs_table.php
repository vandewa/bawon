<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTmtColumnsInAparatursTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aparaturs', function (Blueprint $table) {
            // Ubah tmt_awal menjadi nullable
            $table->date('tmt_awal')->nullable()->change();

            // Ubah tmt_akhir menjadi nullable
            $table->date('tmt_akhir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aparaturs', function (Blueprint $table) {
            // Kembalikan ke NOT NULL (isi default dulu supaya tidak error jika ada data)
            $table->date('tmt_awal')->default(today())->change();
            $table->date('tmt_akhir')->default(today())->change();
        });
    }
}