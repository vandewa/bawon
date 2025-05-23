<?php

namespace App\Livewire\Desa;

use App\Models\Tpk;
use App\Models\ComCode;
use Livewire\Component;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use App\Models\PaketPekerjaan;
use App\Models\PaketKegiatanRinci;
use Illuminate\Support\Facades\DB;
use App\Models\PaketPekerjaanRinci;
use App\Models\Tim;

class PaketKegiatanForm extends Component
{
    use WithFileUploads;

    public $paketPekerjaan;
    public $jumlah_anggaran = 0;
    public $spek_teknis, $kak, $jadwal_pelaksanaan, $rencana_kerja, $hps;
    public $paket_type;
    public $paketTypes = [];
    public $quantities = [];
    public $hargas = [];

    public $rincianList = [];
    public $selectedRincian = [];
    public $tim_id;
    public $tpks = [];

    public function mount($paketPekerjaanId)
    {
        $this->paketPekerjaan = PaketPekerjaan::findOrFail($paketPekerjaanId);
        $this->paketTypes = ComCode::paketTypes();

        $this->rincianList = PaketPekerjaanRinci::where('paket_pekerjaan_id', $paketPekerjaanId)
            ->get()
            ->toArray();

        foreach ($this->rincianList as $rinci) {
            $this->quantities[$rinci['id']] = 0;
        }

        $this->tpks = Tim::
            // ->where('tahun', $this->paketPekerjaan->tahun)
            where('desa_id', $this->paketPekerjaan->desa_id) // pastikan ada desa_id di relasi
            ->get();
    }

    public function updatedSelectedRincian()
    {
        $this->jumlah_anggaran = collect($this->rincianList)
            ->filter(fn($item) => in_array($item['id'], $this->selectedRincian))
            ->sum(function ($item) {
                $qty = $this->quantities[$item['id']] ?? 1;
                $hargaInput = $this->hargas[$item['id']] ?? 0;
                return (float) $hargaInput * (float) $qty;
            });
    }
    public function save()
    {
        $this->validate([
            'tim_id' => 'required|exists:tims,id',
            'paket_type' => 'required',
            'selectedRincian' => 'required|array|min:1',
            'spek_teknis' => 'nullable|file|mimes:pdf,doc,docx',
            'kak' => 'nullable|file|mimes:pdf,doc,docx',
            'jadwal_pelaksanaan' => 'nullable|file|mimes:pdf,doc,docx',
            'rencana_kerja' => 'nullable|file|mimes:pdf,doc,docx',
            'hps' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $jumlah = collect($this->rincianList)
            ->filter(fn($item) => in_array($item['id'], $this->selectedRincian))
            ->sum(function ($item) {
                $qty = $this->quantities[$item['id']] ?? 1;
                return $item['hrg_satuan_pak'] * $qty;
            });

        DB::beginTransaction();

        try {
            $kegiatan = new PaketKegiatan();
            $kegiatan->paket_pekerjaan_id = $this->paketPekerjaan->id;
            $kegiatan->tim_id = $this->tim_id;
            $kegiatan->paket_type = $this->paket_type;
            $kegiatan->jumlah_anggaran = $jumlah;

            $kegiatan->save();
            foreach ($this->selectedRincian as $rinciId) {
                $rinci = collect($this->rincianList)->firstWhere('id', $rinciId);
                $qty = $this->quantities[$rinciId] ?? 1;
                $hargaInput = $this->hargas[$rinciId] ?? 0; // Ambil harga dari input user

                $used = $rinci['quantity'] ?? 0;
                $available = $rinci['jml_satuan_pak'] - $used;

                if ($qty > $available) {
                    $this->addError('quantities.' . $rinciId, 'Jumlah melebihi sisa tersedia.');
                    return;
                }

                PaketKegiatanRinci::create([
                    'paket_kegiatan_id' => $kegiatan->id,
                    'paket_pekerjaan_rinci_id' => $rinciId,
                    'quantity' => $qty,
                    'harga' => $hargaInput, // <-- simpan harga input user ke field harga
                ]);

                // Hitung ulang total quantity dari tabel anak
                $total = PaketKegiatanRinci::whereHas('paketKegiatan', function ($q) {
                    $q->where('paket_pekerjaan_id', $this->paketPekerjaan->id);
                })
                    ->where('paket_pekerjaan_rinci_id', $rinciId)
                    ->sum('quantity');

                PaketPekerjaanRinci::where('id', $rinciId)->update(['quantity' => $total]);
            }
            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            dd($e);


            session()->flash('error', 'Gagal menyimpan negosiasi.');
        }




        $this->js(<<<'JS'
        Swal.fire({
            title: 'Berhasil!',
            text: 'Dokumen berhasil disimpan.',
            icon: 'success',
        })
        JS);

        session()->flash('message', 'Dokumen berhasil disimpan.');
        return redirect()->route('desa.paket-kegiatan.persiapan.edit', $kegiatan->id);
    }

    public function render()
    {
        $this->updatedSelectedRincian();
        return view('livewire.desa.paket-kegiatan-form');
    }
}
