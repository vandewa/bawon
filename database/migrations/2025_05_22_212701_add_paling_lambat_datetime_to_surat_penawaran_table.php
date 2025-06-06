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
        Schema::table('surat_penawaran', function (Blueprint $table) {
             $table->dateTime('paling_lambat')->nullable()->after('tgl_negosiasi');
              $table->integer('jangka_waktu')->nullable()->after('tgl_negosiasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_penawaran', function (Blueprint $table) {
             $table->dropColumn(['paling_lambat']);
             $table->dropColumn('jangka_waktu');
        });
    }
};
