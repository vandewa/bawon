<?php

namespace App\Livewire\Components;


use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Penawaran;
use App\Models\Negoisasi;
use Illuminate\Support\Facades\Storage;
use App\Models\PaketKegiatan;
use Illuminate\Support\Facades\DB;

class PenawaranList extends Component
{
    use WithFileUploads;

    public $penawaranId;
    public $baEvaluasi;
    public $isModalOpen = false;
    public $paketKegiatanId;
    // Menampilkan modal dan menyimpan ID penawaran
    public function openModal($penawaranId)
    {
        $this->penawaranId = $penawaranId;
        $this->isModalOpen = true;
    }

    // Menutup modal
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // Menyimpan BA Evaluasi dan data negosiasi hanya jika penawaran disetujui
       // Menyimpan BA Evaluasi dan data negosiasi hanya jika penawaran disetujui
       public function simpanEvaluasi()
{
    // Validasi upload BA Evaluasi
    $this->validate([
        'baEvaluasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Mulai transaksi DB
    DB::beginTransaction();

    try {
        // Simpan file BA Evaluasi
        $path = $this->baEvaluasi->store('evaluasi/ba_evaluasi', 'public');

        // Ambil penawaran berdasarkan ID
        $penawaran = Penawaran::findOrFail($this->penawaranId);



        // Cek status penawaran, hanya simpan jika status penawaran adalah 'PENAWARAN_ST_01'
        if ($penawaran->penawaran_st == 'PENAWARAN_ST_01') {
            // Update penawaran yang disetujui
            $penawaran->update([
                'penawaran_st' => 'PENAWARAN_ST_02', // Status disetujui
            ]);

            // Update status penawaran lain menjadi 'PENAWARAN_ST_03' (Ditolak)
            Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
                ->where('id', '!=', $penawaran->id)  // Pastikan hanya penawaran selain yang disetujui
                ->update(['penawaran_st' => 'PENAWARAN_ST_03']); // Status Ditolak

            // Simpan path BA Evaluasi di tabel PaketKegiatan
            PaketKegiatan::where('id', $penawaran->paket_kegiatan_id)->update([
                'ba_evaluasi_penawaran' => $path, // Simpan path file
            ]);

            // Simpan data awal di tabel Negosiasi
            Negoisasi::create([
                'paket_kegiatan_id' => $penawaran->paket_kegiatan_id,
                'vendor_id' => $penawaran->vendor_id,
                'nilai' => null,  // Nilai masih null
                'negosiasi_st' => 'NEGOSIASI_ST_01',  // Default status
                'ba_negoisasi' => null,  // BA Negosiasi null
            ]);

            // Commit transaksi jika semua berhasil
            DB::commit();

            // Tutup modal dan reset
            $this->closeModal();

            session()->flash('message', 'Penawaran disetujui, BA Evaluasi berhasil disimpan dan data negosiasi telah dibuat.');

        } else {

            session()->flash('error', 'Penawaran ini sudah disetujui sebelumnya.');
        }
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi error
        DB::rollBack();

        session()->flash('error', 'Terjadi kesalahan, silakan coba lagi.');
    }
}

    public function render()
    {
        $penawarans = Penawaran::with('vendor')->where('paket_kegiatan_id', $this->paketKegiatanId)->get(); // Ambil penawaran beserta vendor
        return view('livewire.components.penawaran-list', compact('penawarans'));
    }
}
