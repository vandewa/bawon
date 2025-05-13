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
        Schema::create('penawaran_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')
            ->constrained('penawarans')
            ->onDelete('cascade'); // hapus jika penawaran utama dihapus

            $table->foreignId('paket_kegiatan_rinci_id')
                ->constrained('paket_kegiatan_rincis')
                ->onDelete('restrict'); // aman dari penghapusan item kegiatan

            $table->double('harga_satuan')->nullable(); // harga satuan yang ditawarkan
            $table->double('subtotal')->nullable();     // hasil dari qty * harga satuan (disimpan untuk efisiensi)
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_items');
    }
};
