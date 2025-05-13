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
        Schema::create('paket_pekerjaan_rincis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_pekerjaan_id')->constrained()->onDelete('cascade'); // relasi ke paket_pekerjaans

            $table->string('kd_posting')->nullable();
            $table->integer('tahun');
            $table->string('kd_desa');
            $table->string('kd_keg');
            $table->string('kd_rincian');
            $table->string('nama_obyek')->nullable();
            $table->string('kd_subrinci')->nullable();
            $table->integer('no_urut')->nullable();
            $table->text('uraian')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->decimal('jml_satuan_pak', 16, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('hrg_satuan_pak', 16, 2)->nullable();
            $table->decimal('anggaran_stlh_pak', 16, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_pekerjaan_rincis');
    }
};
