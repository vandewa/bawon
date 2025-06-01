<?php

namespace App\Livewire\Desa;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Vendor;
use App\Models\ComCode;
use Livewire\Component;
use App\Jobs\kirimPesan;
use App\Models\Negoisasi;
use App\Models\Penawaran;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PenawaranPaket extends Component
{
    use WithFileUploads;

    public $paketKegiatan;
    public $showModalVendor = false;
    public $vendorId;
    public $batasAkhir;
    public $suratUndangan;
    public $keterangan;
    public $searchVendor = '';
    public $penawarans = [];
    public $editMode = false;
    public $idHapus;
    public $negosiasiExists = false;
    public $filterKualifikasi = null;
    public $filterJenisUsaha = null;
    public $filterTagIds = [];

    public $daftarKualifikasi = [];
    public $daftarJenisUsaha = [];

    public function mount($paketKegiatanId)
    {
        $this->paketKegiatan = PaketKegiatan::with(['paketPekerjaan', 'paketType'])->findOrFail($paketKegiatanId);
        $this->negosiasiExists = Negoisasi::where('paket_kegiatan_id', $paketKegiatanId)->exists();
        $this->loadPenawarans();
        $this->daftarKualifikasi = ComCode::where('code_group', 'KUALIFIKASI_ST')->get();
        $this->daftarJenisUsaha = ComCode::where('code_group', 'JENIS_USAHA_ST')->get();
    }

    public function updatedShowModalVendor($value)
    {
       $this->js(<<<'JS'
        setTimeout(function() {
            $('#tags-filter').select2({
                  placeholder: 'Pilih Klasifikasi',    // <-- di sini
                    allowClear: true,
            });
            $('#tags-filter').on('change', function(e) {
                var orderlist = $('#tags-filter').select2("val");

                $wire.set('filterTagIds', orderlist);
            });
        }, 500);
        JS);

    }


    public function loadPenawarans()
    {
        $this->penawarans = Penawaran::where('paket_kegiatan_id', $this->paketKegiatan->id)
            ->with('vendor')
            ->get()
            ->toArray();
    }

    public function tambahVendor($vendorId)
    {

        $this->vendorId = $vendorId;
        $this->batasAkhir = null;
        $this->suratUndangan = null;
        $this->keterangan = null;
        $this->editMode = false;

    }

    public function simpanPenawaranVendor()
    {
        $this->validate([
            'vendorId' => 'required|exists:vendors,id',
            'batasAkhir' => 'required|date|after:today',
            'suratUndangan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $this->suratUndangan->store('penawarans/surat_undangan');

        Penawaran::updateOrCreate(
            [
                'paket_kegiatan_id' => $this->paketKegiatan->id,
                'vendor_id' => $this->vendorId,
            ],
            [
                'batas_akhir' => $this->batasAkhir,
                'surat_undangan' => $path,
                'keterangan' => $this->keterangan,
            ]
        );

        $this->resetForm();
        $this->loadPenawarans();
        session()->flash('message', 'Penawaran berhasil disimpan.');
    }

    public function editPenawaran($vendorId)
    {
        $penawaran = Penawaran::where('paket_kegiatan_id', $this->paketKegiatan->id)
            ->where('vendor_id', $vendorId)
            ->firstOrFail();

        $this->vendorId = $vendorId;
        $this->batasAkhir = $penawaran->batas_akhir;
        $this->keterangan = $penawaran->keterangan;
        $this->editMode = true;
    }

    public function delete($vendorId)
    {
        $this->idHapus = $vendorId;
        $this->js(<<<'JS'
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah kamu ingin menghapus data ini? proses ini tidak dapat dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.hapus()
            }
        })
        JS);
    }

    public function hapus()
    {
        $penawaran = Penawaran::where('paket_kegiatan_id', $this->paketKegiatan->id)
            ->where('vendor_id', $this->idHapus)
            ->first();

        if ($penawaran) {
            $penawaran->delete();
            $this->loadPenawarans();

            $this->js(<<<'JS'
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data penawaran berhasil dihapus!',
                icon: 'success'
            })
            JS);
        }
    }
    public function konfirmasiKirimUndangan()
    {
        $jumlahPenawaran = count($this->penawarans);
        $anggaran = $this->paketKegiatan->jumlah_anggaran ?? 0;

        // Jika anggaran ≥ 10jt → minimal 2 penawaran
        if ($anggaran >= 10000000 && $jumlahPenawaran < 2) {
            $this->js(<<<'JS'
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Minimal harus ada 2 undangan untuk anggaran di atas atau sama dengan 10 juta.',
                });
            JS);
            return;
        }

        // // Jika anggaran < 10jt → maksimal 1 penawaran
        // if ($anggaran < 10000000 && $jumlahPenawaran > 1) {
        //     $this->js(<<<'JS'
        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Gagal',
        //             text: 'Untuk anggaran di bawah 10 juta, maksimal hanya 1 undangan yang diperbolehkan.',
        //         });
        //     JS);
        //     return;
        // }

        // Jika jumlah memenuhi, lanjutkan konfirmasi kirim
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua undangan akan dikirimkan sekarang?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.kirimUndangan()
                }
            })
        JS);




    }



    public function kirimUndangan()
    {
        Penawaran::where('paket_kegiatan_id', $this->paketKegiatan->id)
            ->update(['kirim_st' => true]);


            $a = Penawaran::with(['vendor'])->where('paket_kegiatan_id', $this->paketKegiatan->id)->get();

             // kirim pesan whatsapp
             foreach ($a as $penawaran) {
                $vendor = $penawaran->vendor ?? null;
                $namaVendor = $penawaran->vendor->nama_perusahaan ?? 'Penyedia';
                $nilai = number_format($penawaran->nilai, 0, ',', '.');
                $desa = $this->paketKegiatan->paketPekerjaan->desa->name ?? null;
                $batasAkhir = $penawaran->batas_akhir ?? null;
                $tanggalIndo = $batasAkhir
                ? Carbon::parse($batasAkhir)->locale('id')->translatedFormat('d F Y')
                : '-';

                if ( $vendor && $vendor->telepon) {
                    $namaPaket = $this->paketKegiatan->paketPekerjaan->nama_kegiatan ?? 'Kegiatan Pengadaan';

                    $pesan = "Yth. *{$namaVendor}*,\n\nKami mengundang perusahaan Anda untuk mengajukan *penawaran harga* terkait kegiatan: *{$namaPaket}*.\n\nMohon agar penawaran dapat dikirim melalui sistem sebelum batas waktu yang ditentukan *({$tanggalIndo})*.\n\nTerima kasih atas perhatian dan kerja samanya.\n\nHormat kami,\nTim Pengadaan *{$desa}*";

                    $telepon = $penawaran->vendor->telepon ?? '089604484626'; // fallback jika belum ada

                    kirimPesan::dispatch($telepon, $pesan);
                }
            }

        $this->loadPenawarans(); // Refresh tabel



        $route = route('desa.penawaran.pelaksanaan.index');

        $this->js(<<<JS
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Dokumen berhasil diperbarui.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = "$route";
            });
        JS);
    }


    public function preview($path)
    {
        return Storage::disk('public')->download($path);
    }

    public function resetForm()
    {
        $this->vendorId = null;
        $this->batasAkhir = null;
        $this->suratUndangan = null;
        $this->keterangan = null;
        $this->editMode = false;
    }

    public function render()
    {

            $tags = Tag::orderBy('nama')->get();

         $vendors = Vendor::with('tags')
            ->when($this->filterKualifikasi, function ($q) {
                $q->where('kualifikasi', $this->filterKualifikasi); // kolom pada table vendors
            })
            ->when($this->filterJenisUsaha, function ($q) {
                $q->where('jenis_usaha', $this->filterJenisUsaha); // kolom pada table vendors
            })
            ->when($this->filterTagIds, function ($q) {
                $q->whereHas('tags', function ($q2) {
                    $q2->whereIn('tags.id', $this->filterTagIds);
                });
            })
            ->paginate(10);

            return view('livewire.desa.penawaran-paket', [
                'vendors' => $vendors,
                'tags' => $tags,
            ]);
    }
}
