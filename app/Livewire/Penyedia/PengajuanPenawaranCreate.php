<?php

namespace App\Livewire\Penyedia;

use App\Models\Penawaran;
use Livewire\Component;
use Livewire\WithFileUploads;
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
            'paketKegiatan.rincian',
            'items'
        ])->findOrFail($penawaranId);

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
            'bukti_setor_pajak' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dok_penawaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'dok_kebenaran_usaha' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $this->penawaran->nilai = $this->nilai;
        $this->penawaran->tanggal_upload_dok = now();
        $this->penawaran->keterangan = $this->keterangan;

        if ($this->bukti_setor_pajak) {
            $this->penawaran->bukti_setor_pajak = $this->bukti_setor_pajak->store('penawaran/bukti_setor', 'public');
        }
        if ($this->dok_penawaran) {
            $this->penawaran->dok_penawaran = $this->dok_penawaran->store('penawaran/dok_penawaran', 'public');
        }
        if ($this->dok_kebenaran_usaha) {
            $this->penawaran->dok_kebenaran_usaha = $this->dok_kebenaran_usaha->store('penawaran/dok_kebenaran', 'public');
        }

        $this->penawaran->save();

        // 💡 Simpan Penawaran Item
        $total = 0;
        $this->penawaran->items()->delete(); // reset dulu

        foreach ($this->penawaranItems as $rinciId => $hargaSatuan) {
            $rinci = $this->penawaran->paketKegiatan->rincian->firstWhere('id', $rinciId);
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

        session()->flash('message', 'Penawaran berhasil diperbarui.');

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
            $rinci = $this->penawaran->paketKegiatan->rincian->firstWhere('id', $rinciId);
            if ($rinci) {
                $this->nilai += $harga * $rinci->quantity;
            }
        }
        return view('livewire.penyedia.pengajuan-penawaran-create');
    }
}
