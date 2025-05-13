<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;
use App\Models\Negoisasi;
use App\Models\Penawaran;
use App\Models\NegosiasiLog;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class NegosiasiPage extends Component
{
    use WithFileUploads;

    public $paket_kegiatan_id;
    public $negosiasi_id;
    public $penawaran;
    public $penawaranAwalDetail;
    public $keterangan;
    public $status_negosiasi = 'pending';
    public $ba_negoisasi;
    public $nilai;
    public $negosiasiLogs = [];
    public $negosiasiStatus = '';
    public $nilaiDisepakati;
    public $baNegoisasiPath;

    public $paketKegiatan; // Detail kegiatan
    public $vendor; // Detail vendor

    public $showModal = false;
    public $lastSenderId;
    public $logIdDisetujui;
    public $logSudahDisetujui = false;

    public $logItems = [];

    protected $rules = [
        'penawaran' => 'required|numeric',
        'keterangan' => 'nullable|string',
        'ba_negoisasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nilai' => 'nullable|numeric',
    ];

    public function mount($paket_kegiatan_id)
    {
        $this->paket_kegiatan_id = $paket_kegiatan_id;
        $this->loadNegosiasiData(); // Memuat data negosiasi berdasarkan paket_kegiatan_id
        $this->loadNegosiasiLogs(); // Memuat log negosiasi
        $this->loadKegiatanAndVendor(); // Memuat detail kegiatan dan vendor
        $this->loadLogItemsDariLogSebelumnya();
    }



    public function loadNegosiasiData()
    {
        $paketKegiatan = PaketKegiatan::find($this->paket_kegiatan_id);

        if ($paketKegiatan) {
            $this->paketKegiatan = $paketKegiatan; // Menyimpan detail kegiatan
            $negosiasi = $paketKegiatan->negosiasi;
            $this->penawaranAwalDetail = Penawaran::where('paket_kegiatan_id', $this->paket_kegiatan_id)
            ->where('vendor_id', $negosiasi->vendor_id)->first();

            $this->negosiasiStatus = $negosiasi->negosiasi_st;
            $this->negosiasi_id = $negosiasi->id;
            $this->baNegoisasiPath = $this->negosiasi->ba_negoisasi ?? null;

        }
        $rincianList = $this->paketKegiatan->rincian; // pastikan relasi `rincian` ada di model PaketKegiatan


    }

    public function loadLogItemsDariLogSebelumnya()
    {
        $lastOpponentLog = NegosiasiLog::with('items.rincian.rincian')
        ->where('negoisasi_id', $this->negosiasi_id)
        ->where('user_id', '!=', auth()->id())
        ->orderByDesc('created_at')
        ->first();



    if ($lastOpponentLog && $lastOpponentLog->items()->exists()) {

        $this->logItems = $lastOpponentLog->items->map(function ($item) {

            return [
                'paket_kegiatan_rinci_id' => $item->paket_kegiatan_rinci_id,
                'uraian' => $item->rincian->rincian->uraian ?? '-',
                'quantity' => $item->rincian->quantity ?? 1,
                'penawaran' => $item->penawaran ?? 0, // harga satuan terakhir
                'catatan' => null,
            ];
        })->toArray();
    } else {
        // fallback jika belum ada log lawan, bisa dari rincian awal kegiatan
        $this->logItems = $this->paketKegiatan->rincian->map(function ($item) {
            return [
                'paket_kegiatan_rinci_id' => $item->id,
                'uraian' => $item->rincian->rincian->uraian,
                'quantity' => $item->quantity ?? 1,
                'penawaran' => 0,
                'catatan' => null,
            ];
        })->toArray();
    }
}


    public function loadNegosiasiLogs()
    {
        if ($this->negosiasi_id) {
            $this->negosiasiLogs = NegosiasiLog::with('user')
                ->where('negoisasi_id', $this->negosiasi_id)
                ->orderBy('created_at', 'desc')
                ->get();

            $this->logSudahDisetujui = $this->negosiasiLogs->contains('status_st', true);
        }
    }

    // Fungsi untuk memuat detail kegiatan dan vendor
    public function loadKegiatanAndVendor()
    {
        $this->paketKegiatan =$this->paketKegiatan = PaketKegiatan::with(['negosiasi.status', 'paketPekerjaan'])->find($this->paket_kegiatan_id);

            $this->vendor = Vendor::find($this->paketKegiatan->negosiasi->vendor_id);

    }

    public function saveNegosiasi()
{
    // Hitung total keseluruhan untuk log utama
    $this->penawaran = collect($this->logItems)->sum(function ($item) {
        return ($item['penawaran'] ?? 0) * ($item['quantity'] ?? 1);
    });

    $this->validate();

    DB::beginTransaction();

    try {
        // Simpan log utama
        $log = NegosiasiLog::create([
            'negoisasi_id' => $this->negosiasi_id,
            'penawaran' => $this->penawaran, // total = harga satuan × qty
            'keterangan' => $this->keterangan,
            'user_id' => auth()->id(),
        ]);

        // Simpan semua item (harga satuan saja yang disimpan)
        foreach ($this->logItems as $item) {
            $log->items()->create([
                'paket_kegiatan_rinci_id' => $item['paket_kegiatan_rinci_id'],
                'penawaran' => $item['penawaran'], // harga satuan disimpan
                'catatan' => $item['catatan'],
            ]);
        }

        DB::commit();

        $this->loadNegosiasiData();
        $this->loadNegosiasiLogs();
        session()->flash('message', 'Negosiasi telah diajukan.');

        $this->reset('keterangan', 'penawaran'); // reset form utama (logItems tetap)
    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);
        session()->flash('error', 'Gagal menyimpan negosiasi.');
    }
}


    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function uploadBANegosiasi()
{
    $this->validate([
        'ba_negoisasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nilaiDisepakati' => 'required|numeric|min:0',
    ]);

    $path = $this->ba_negoisasi->store('negoisasi/ba');

    // Update pada tabel negoisasis
    Negoisasi::where('id', $this->negosiasi_id)->update([
        'ba_negoisasi' => $path,
        'negosiasi_st' => 'NEGOSIASI_ST_02',
        'nilai' => $this->nilaiDisepakati,
    ]);

    // Update juga ke paket_kegiatans
    PaketKegiatan::where('id', $this->paket_kegiatan_id)->update([
        'nilai_kesepakatan' => $this->nilaiDisepakati,
    ]);

    $this->loadNegosiasiData();
    $this->loadNegosiasiLogs();

    session()->flash('message', 'BA Negosiasi dan Nilai Kesepakatan berhasil diupload.');

    $this->reset('ba_negoisasi', 'nilaiDisepakati');
    $this->closeModal();
}



public function konfirmasiSetujuiLog($id)
{
    $this->logIdDisetujui = $id;

    $this->js(<<<'JS'
        Swal.fire({
            title: 'Setujui Penawaran?',
            text: "Penawaran ini akan disetujui. Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.setujuiLog()
            }
        })
    JS);
}
public function setujuiLog()
{
    $log = NegosiasiLog::findOrFail($this->logIdDisetujui);

    if ($log->status_st) {
        session()->flash('message', 'Log sudah disetujui sebelumnya.');
        return;
    }

    $log->update(['status_st' => true]);

    $this->loadNegosiasiLogs();

    $this->js(<<<'JS'
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Log negosiasi telah disetujui.',
        })
    JS);
}



    public function render()
    {
        $this->lastSenderId = $this->negosiasiLogs->last()?->user_id ?? null;

        return view('livewire.negosiasi-page');
    }
}
