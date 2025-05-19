<?php

namespace App\Livewire\Penyedia;

use App\Models\PaketKegiatanRinci;
use Livewire\Component;
use App\Models\Penawaran;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengajuanPenawaranCreate extends Component
{
    use WithFileUploads;

    public $penawaranId;
    public $penawaran;
    public $nilai;
    public $bukti_setor_pajak;
    public $dok_penawaran;
    public $dok_kebenaran_usaha;
    public $keterangan;
    public $penawaranItems = [];

    public function mount($penawaranId)
    {

        $this->penawaran = Penawaran::with([
            'paketKegiatan.paketPekerjaan.desa',
            'paketKegiatan.merinci',
            'items'
        ])->findOrFail($penawaranId);
        if(auth()->user()->vendor_id){
            if($this->penawaran->vendor_id != auth()->user()->vendor_id){
                abort(403);
            }
        }

        $this->nilai = $this->penawaran->nilai;
        $this->keterangan = $this->penawaran->keterangan;


        // Pre-fill harga jika sudah pernah diisi
        foreach ($this->penawaran->items as $item) {

            $this->penawaranItems[$item->paket_kegiatan_rinci_id] = $item->harga_satuan;
        }
    }

    public function save()
{
    $this->validate([
        'nilai' => ['required', 'numeric', 'lte:' . $this->penawaran->paketKegiatan->jumlah_anggaran],
        'dok_penawaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // Ambil vendor terkait
    $vendor = $this->penawaran->vendor;

    // Cek kelengkapan file di vendor
    if (!$vendor || !$vendor->bukti_setor_pajak_file || !$vendor->dok_kebenaran_usaha_file) {
        session()->flash('error', 'Bukti setor pajak dan/atau dokumen kebenaran usaha di data vendor belum diupload. Silakan lengkapi data vendor terlebih dahulu.');
        $this->js(<<<'JS'
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Bukti setor pajak dan/atau dokumen kebenaran usaha belum diupload di data vendor.',
                timer: 3000,
                showConfirmButton: false
            });
        JS);
        return;
    }

    DB::beginTransaction();
    try {
        $this->penawaran->nilai = $this->nilai;
        $this->penawaran->tanggal_upload_dok = now();
        $this->penawaran->keterangan = $this->keterangan;

        // **ambil dari vendor, bukan upload**
        $this->penawaran->bukti_setor_pajak = $vendor->bukti_setor_pajak_file;
        $this->penawaran->dok_kebenaran_usaha = $vendor->dok_kebenaran_usaha_file;

        // Dokumen penawaran masih bisa upload baru
        if ($this->dok_penawaran) {
            $this->penawaran->dok_penawaran = $this->dok_penawaran->store('penawaran/dok_penawaran');
        }

        $this->penawaran->save();

        // 💡 Simpan Penawaran Item
        $total = 0;
        $this->penawaran->items()->delete(); // reset dulu

        foreach ($this->penawaranItems as $rinciId => $hargaSatuan) {

           $rinci = PaketKegiatanRinci::find($rinciId);
            if (!$rinci) continue;

            $subtotal = $hargaSatuan * $rinci->quantity;
            $total += $subtotal;

            $this->penawaran->items()->create([
                'paket_kegiatan_rinci_id' => $rinciId,
                'harga_satuan' => $hargaSatuan,
                'subtotal' => $subtotal,
            ]);
        }

        $this->penawaran->update(['nilai' => $total]);
        DB::commit();

        session()->flash('message', 'Penawaran berhasil diperbarui.');
    } catch (\Throwable $e) {
        DB::rollBack();
        dd($e);
        $this->js(<<<'JS'
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Penawaran gagal disimpan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "/penyedia/penawaran-index";
        });
    JS);
        return;
    }

    $this->js(<<<'JS'
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Penawaran berhasil disimpan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "/penyedia/penawaran-index";
        });
    JS);
}


    public function render()
    {
        $this->nilai = 0;

        foreach ($this->penawaranItems as $rinciId => $harga) {


            $rinci = PaketKegiatanRinci::find($rinciId);

            if ($rinci) {
                $harga = (float) $harga;
                $qty = (float) $rinci->quantity;

                $this->nilai += $harga * $qty;
            }

        }
        return view('livewire.penyedia.pengajuan-penawaran-create');
    }
}
