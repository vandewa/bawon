<?php

namespace App\Livewire\Desa;

use App\Models\PaketPekerjaan;
use App\Models\Desa;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PaketPekerjaanIndex extends Component
{
    use WithPagination;

    public $cari = '';
    public $filterDesa = '';
    public $filterTahun = '';
    public $filterSumber = '';
    public $idHapus;
    public $showModal = false;
    public $isEdit = false;

    // form properties
    public $paketId;
    public $desa_id;
    public $tahun;
    public $nama_kegiatan;
    public $sumberdana;
    public $kd_keg;
    public $nilaipak;
    public $satuan;
    public $pagu_pak;
    public $nm_pptkd;
    public $jbt_pptkd;
    public $nama_bidang;
    public $nama_subbidang;

    public function render()
    {
        // query dengan relasi desa
        $posts = PaketPekerjaan::with('desa')
        ->withSum('paketKegiatans', 'nilai_kesepakatan');
        if (auth()->user()->desa_id) {
            $posts->where('desa_id', auth()->user()->desa_id);
        }

        // filter teks nama kegiatan
        if ($this->cari) {
            $posts->where('nama_kegiatan', 'like', '%'.$this->cari.'%');
        }
        // filter by desa
        if ($this->filterDesa) {
            $posts->where('desa_id', $this->filterDesa);
        }
        // filter by tahun
        if ($this->filterTahun) {
            $posts->where('tahun', $this->filterTahun);
        }
        // filter by sumber dana
        if ($this->filterSumber) {
            $posts->where('sumberdana', 'like', '%'.$this->filterSumber.'%');
        }

        $posts = $posts->latest()->paginate(10);

        $desas = Desa::query();

        if (auth()->user()->desa_id) {
            $desas->where('id', auth()->user()->desa_id);
        }

        $desas = $desas->get();

        $tahuns = PaketPekerjaan::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('livewire.desa.paket-pekerjaan-index', [
            'posts'  => $posts,
            'desas'  => $desas,
            'tahuns' => $tahuns,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $paket = PaketPekerjaan::findOrFail($id);

        $this->paketId        = $paket->id;
        $this->desa_id        = $paket->desa_id;
        $this->tahun          = $paket->tahun;
        $this->nama_kegiatan  = $paket->nama_kegiatan;
        $this->sumberdana     = $paket->sumberdana;
        $this->kd_keg         = $paket->kd_keg;
        $this->nilaipak       = $paket->nilaipak;
        $this->satuan         = $paket->satuan;
        $this->pagu_pak       = $paket->pagu_pak;
        $this->nm_pptkd       = $paket->nm_pptkd;
        $this->jbt_pptkd      = $paket->jbt_pptkd;
        $this->nama_bidang    = $paket->nama_bidang;
        $this->nama_subbidang = $paket->nama_subbidang;

        $this->isEdit   = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'desa_id'       => 'required',
            'tahun'         => 'required|numeric',
            'nama_kegiatan' => 'required',
            'sumberdana'    => 'required',
            'kd_keg'        => 'required|string',
            'nilaipak'      => 'required|numeric',
            'satuan'        => 'required|string',
            'pagu_pak'      => 'required|numeric',
            'nm_pptkd'      => 'nullable|string',
            'jbt_pptkd'     => 'nullable|string',
            'nama_bidang'   => 'required|string',
            'nama_subbidang'=> 'required|string',
        ]);

        PaketPekerjaan::updateOrCreate(
            ['id' => $this->paketId],
            [
                'desa_id'        => $this->desa_id,
                'tahun'          => $this->tahun,
                'nama_kegiatan'  => $this->nama_kegiatan,
                'sumberdana'     => $this->sumberdana,
                'kd_desa'        => Desa::find($this->desa_id)->kode_desa ?? '',
                'kd_keg'         => $this->kd_keg,
                'nilaipak'       => $this->nilaipak,
                'satuan'         => $this->satuan,
                'pagu_pak'       => $this->pagu_pak,
                'nm_pptkd'       => $this->nm_pptkd,
                'jbt_pptkd'      => $this->jbt_pptkd,
                'nama_bidang'    => $this->nama_bidang,
                'nama_subbidang' => $this->nama_subbidang,
                'kegiatan_st'    => 'KEGIATAN_ST_01',
            ]
        );

        $this->resetForm();
        $this->js("Swal.fire('Berhasil', 'Data berhasil disimpan', 'success')");
    }

    public function delete($id)
    {
        $this->idHapus = $id;
        $this->js(<<<'JS'
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.hapus()
                }
            })
        JS
        );
    }

    #[On('hapus')]
    public function hapus()
    {
        PaketPekerjaan::destroy($this->idHapus);
        $this->js("Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')");
    }

    public function resetForm()
    {
        $this->reset([
            'paketId','desa_id','tahun','nama_kegiatan','sumberdana',
            'kd_keg','nilaipak','satuan','pagu_pak','nm_pptkd',
            'jbt_pptkd','nama_bidang','nama_subbidang',
            'isEdit','showModal'
        ]);
    }

    // tambahkan method resetFilters untuk tombol Reset filter
    public function resetFilters()
    {
        $this->reset(['cari', 'filterDesa', 'filterTahun', 'filterSumber']);
    }
}
