<?php

namespace App\Livewire;

use App\Models\Negoisasi;
use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\NegosiasiLog;
use App\Models\Vendor;
use Livewire\WithFileUploads;

class NegosiasiPage extends Component
{
    use WithFileUploads;

    public $paket_kegiatan_id;
    public $negosiasi_id;
    public $penawaran;
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
    }

    public function loadNegosiasiData()
    {
        $paketKegiatan = PaketKegiatan::find($this->paket_kegiatan_id);

        if ($paketKegiatan) {
            $this->paketKegiatan = $paketKegiatan; // Menyimpan detail kegiatan
            $negosiasi = $paketKegiatan->negosiasi;
            $this->negosiasiStatus = $negosiasi->negosiasi_st;
            $this->negosiasi_id = $negosiasi->id;
            $this->baNegoisasiPath = $this->negosiasi->ba_negoisasi ?? null;

        }
    }

    public function loadNegosiasiLogs()
    {
        if ($this->negosiasi_id) {
            $this->negosiasiLogs = NegosiasiLog::where('negoisasi_id', $this->negosiasi_id)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    // Fungsi untuk memuat detail kegiatan dan vendor
    public function loadKegiatanAndVendor()
    {
        $paketKegiatan = PaketKegiatan::find($this->paket_kegiatan_id);
        $this->vendor = Vendor::find($paketKegiatan->vendor_id); // Menyimpan detail vendor
    }

    public function saveNegosiasi()
    {
        $this->validate();

        $negosiasiLog = NegosiasiLog::create([
            'negoisasi_id' => $this->negosiasi_id,
            'penawaran' => $this->penawaran,
            'keterangan' => $this->keterangan,
            'user_id' => auth()->id(),
        ]);

        $this->loadNegosiasiLogs();
        $this->loadNegosiasiData();

        session()->flash('message', 'Negosiasi telah diajukan');
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

    $path = $this->ba_negoisasi->store('negoisasi/ba', 'public');

    Negoisasi::where('id', $this->negosiasi_id)->update([
        'ba_negoisasi' => $path,
        'negosiasi_st' => 'NEGOSIASI_ST_02',
        'nilai' => $this->nilaiDisepakati, // Update nilai juga
    ]);

    $this->loadNegosiasiData();
    $this->loadNegosiasiLogs();

    session()->flash('message', 'BA Negosiasi dan Nilai Disepakati berhasil diupload.');

    $this->reset('ba_negoisasi', 'nilaiDisepakati');
    $this->closeModal();
}


    public function render()
    {
        $this->lastSenderId = $this->negosiasiLogs->last()?->user_id ?? null;

        return view('livewire.negosiasi-page');
    }
}
