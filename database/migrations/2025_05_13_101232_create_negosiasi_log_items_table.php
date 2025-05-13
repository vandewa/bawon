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
        Schema::create('negosiasi_log_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negosiasi_log_id')
                ->constrained('negosiasi_logs')
                ->onDelete('cascade'); // ikut terhapus jika log dihapus

            $table->foreignId('paket_kegiatan_rinci_id')
                ->constrained('paket_kegiatan_rincis')
                ->onDelete('restrict'); // tidak boleh hapus item yang sedang dinego

            $table->double('penawaran')->nullable(); // harga/penawaran per item
            $table->text('catatan')->nullable();     // opsional, keterangan item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negosiasi_log_items');
    }
};
