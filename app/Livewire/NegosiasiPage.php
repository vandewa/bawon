<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;
use App\Jobs\kirimPesan;
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
    public $penawaran = 0;
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
    public $penetapanPemenang;
    public $jumlahPenawaran = 0;

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
        $this->updatePenawaranTotal();
    }

    public function updatedLogItems()
    {
        $this->updatePenawaranTotal();
    }

    public function updatePenawaranTotal()
    {
        $this->penawaran = collect($this->logItems)
            ->sum(function ($item) {
                return ((float) ($item['penawaran'] ?? 0)) * ((float) ($item['quantity'] ?? 1));
            });
    }



    public function loadNegosiasiData()
    {
        $paketKegiatan = PaketKegiatan::with('penawarans')->find($this->paket_kegiatan_id);
        $this->jumlahPenawaran  = $paketKegiatan->penawarans->count();

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
                'uraian' => $item->rincian->rincian->uraian?? '-',
                'quantity' => $item->quantity ?? 0,
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
        $this->kirimWaNego($log->id);


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
        // Ambil log yang sudah disetujui
            $logDisetujui = NegosiasiLog::where('negoisasi_id', $this->negosiasi_id)
            ->where('status_st', true)
            ->orderByDesc('created_at')
            ->first();

        if ($logDisetujui) {
            $this->nilaiDisepakati = $logDisetujui->penawaran;
        }

        $this->showModal = true;
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
    $baPemenangPath = null;
    if ($this->penetapanPemenang) {
        $baPemenangPath = $this->penetapanPemenang->store('dokumen/ba_pemenang');
    }
    DB::beginTransaction();

    try {
    // Update pada tabel negoisasis
    Negoisasi::where('id', $this->negosiasi_id)->update([
        'ba_negoisasi' => $path,
        'negosiasi_st' => 'NEGOSIASI_ST_02',
        'nilai' => $this->nilaiDisepakati,
    ]);



    // Update juga ke paket_kegiatans
    PaketKegiatan::where('id', $this->paket_kegiatan_id)->update([
        'nilai_kesepakatan' => $this->nilaiDisepakati,
        'ba_pemenang' => $baPemenangPath
    ]);
    DB::commit();
    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);
        session()->flash('error', 'Gagal menyimpan negosiasi.');
    }

    $this->loadNegosiasiData();
    $this->loadNegosiasiLogs();

    session()->flash('message', 'BA Negosiasi dan Nilai Kesepakatan berhasil diupload.');

    $this->reset('ba_negoisasi', 'nilaiDisepakati');
    $this->closeModal();

    $route = route('desa.penawaran.pelaksanaan.index');

    $this->js(<<<JS
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'BA Negosiasi dan Nilai Kesepakatan berhasil diupload.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = "$route";
        });
    JS);
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

public function kirimWaNego($id){

    $log = NegosiasiLog::with(['negosiasi' => function($a){
        $a->with(['paketKegiatan.paketPekerjaan.desa.user','vendor']);
    }])->findOrFail($id);

    if (auth()->user()->hasRole('vendor')) {

        $namaVendor = $log->negosiasi->vendor->nama_perusahaan ?? 'Penyedia';
        $nilai = number_format($log->penawaran, 0, ',', '.');
        $desa = $log->negosiasi->paketKegiatan->paketPekerjaan->desa->user ?? null;


    if ($desa && $desa->whatsapp) {
        $namaDesa = $desa->nama ?? 'Desa';
        $pesanDesa = "Halo {$namaDesa},\n\nPenyedia telah melakukan penawaran melalui proses negosiasi dengan nilai sebesar *Rp {$nilai}*.\n\n.";
        kirimPesan::dispatch($desa->whatsapp, $pesanDesa);

    }
    } else {
        $namaVendor = $log->negosiasi->vendor->nama_perusahaan ?? 'Penyedia';
        $nilai = number_format($log->penawaran, 0, ',', '.');

        $pesan = "Halo {$namaVendor},\n\Desa telah melakukan penawaran melalui proses negosiasi dengan nilai sebesar *Rp {$nilai}*.\n\n.";
        $telepon = $log->negosiasi->vendor->telepon ?? null;
        if(!$telepon){
            kirimPesan::dispatch($telepon, $pesan );
        }

    }
}
public function setujuiLog()
{
    $log = NegosiasiLog::with(['negosiasi' => function($a){
        $a->with(['paketKegiatan.paketPekerjaan.desa.user','vendor']);
    }])->findOrFail($this->logIdDisetujui);


    if (auth()->user()->hasRole('vendor')) {
        $namaVendor = $log->negosiasi->vendor->nama_perusahaan ?? 'Penyedia';
        $nilai = number_format($log->penawaran, 0, ',', '.');
        $desa = $log->negosiasi->paketKegiatan->paketPekerjaan->desa->user ?? null;
        $whatsapp = $desa->whatsapp ?? null;

        $namaKegiatan = $log->negosiasi->paketKegiatan->paketPekerjaan->nama_kegiatan ?? 'Kegiatan';

    if ($desa && $desa->whatsapp) {
        $desa = $log->negosiasi->paketKegiatan->paketPekerjaan->desa ?? null;
        $namaDesa = $desa->name ?? 'Desa';
        $pesanDesa = "Halo *{$namaDesa}*,\n\nPenawaran anda dalam kegiatan *{$namaKegiatan}* telah disetujui oleh *{$namaVendor}* melalui proses negosiasi dengan nilai sebesar *Rp {$nilai}*.\n\nTerima kasih atas partisipasinya.";
        kirimPesan::dispatch( $whatsapp, $pesanDesa);
    }
    } else {
        $namaVendor = $log->negosiasi->vendor->nama_perusahaan ?? 'Penyedia';
        $namaKegiatan = $log->negosiasi->paketKegiatan->paketPekerjaan->nama_kegiatan ?? 'Kegiatan';
        $desa = $log->negosiasi->paketKegiatan->paketPekerjaan->desa ?? null;
        $namaDesa = $desa->name ?? 'Desa';
        $nilai = number_format($log->penawaran, 0, ',', '.');

        $pesan = "Halo *{$namaVendor}*,\n\nPenawaran Anda dalam kegiatan *{$namaKegiatan}* telah disetujui oleh *{$namaDesa}* melalui proses negosiasi dengan nilai sebesar *Rp {$nilai}*.\n\nTerima kasih atas partisipasinya.";
        $telepon = $log->negosiasi->vendor->telepon ?? null;

        if($telepon){
            kirimPesan::dispatch($telepon, $pesan);
        }

    }



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
        $this->lastSenderId = $this->negosiasiLogs->first()?->user_id ?? null;



        return view('livewire.negosiasi-page');
    }
}
