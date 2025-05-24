<?php

namespace App\Livewire\Desa;

use App\Models\Tpk;
use App\Models\ComCode;
use Livewire\Component;
use App\Models\PaketKegiatan;
use Livewire\WithFileUploads;
use App\Models\PaketPekerjaan;
use App\Models\PaketKegiatanRinci;
use App\Models\PaketPekerjaanRinci;
use App\Models\Tim;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaketKegiatanEdit extends Component
{
    use WithFileUploads;

    public $paketKegiatan;
    public $paketPekerjaan;
    public $jumlah_anggaran;
    public $paket_type;

    public $selectedRincian = [];
    public $quantities = [];
    public $hargas = [];

    public $spek_teknis, $kak, $jadwal_pelaksanaan, $rencana_kerja, $hps;

    public $paketTypes = [];

    public $tim_id;
    public $tpks = [];

    public function mount($id)
    {
        $this->paketKegiatan = PaketKegiatan::with(['paketPekerjaan', 'rincian'])->findOrFail($id);
        $this->paketPekerjaan = $this->paketKegiatan->paketPekerjaan;

        if (!$this->paketPekerjaan) {
            abort(404, 'Paket Pekerjaan tidak ditemukan.');
        }

        $this->jumlah_anggaran = $this->paketKegiatan->jumlah_anggaran;
        $this->paket_type = $this->paketKegiatan->paket_type;
        $this->paketTypes = ComCode::paketTypes();
        $this->tim_id = $this->paketKegiatan->tim_id;
        $this->selectedRincian = $this->paketKegiatan->rincian()->pluck('paket_pekerjaan_rinci_id')->toArray();
        $this->quantities = $this->paketKegiatan->rincian->pluck('quantity', 'paket_pekerjaan_rinci_id')->toArray();

        // *** Tambahan: isi harga dari data edit (paket_kegiatan_rincis) ***
        $this->hargas = [];
        foreach ($this->paketKegiatan->rincian as $rinci) {
            // Ambil harga dari pivot/relasi (dari tabel paket_kegiatan_rincis)
              $this->quantities[$rinci->pivot->paket_pekerjaan_rinci_id] = $rinci->pivot->quantity ?? 0;
            $this->hargas[$rinci->pivot->paket_pekerjaan_rinci_id] = $rinci->pivot->harga ?? $rinci->hrg_satuan_pak;
        }

        $this->tpks = Tim::
            where('tahun', $this->paketPekerjaan->tahun)
            ->where('desa_id', $this->paketPekerjaan->desa_id)
            ->get();
    }


    public function updatedSelectedRincian()
    {
        $this->hitungAnggaran();
    }

    public function updatedQuantities()
    {
        $this->hitungAnggaran();
    }

    private function hitungAnggaran()
    {
        $total = 0;

        foreach ($this->selectedRincian as $rinciId) {
            $qty = $this->quantities[$rinciId] ?? 1;
            $hargaInput = $this->hargas[$rinciId] ?? 0; // harga input user
            $total += $qty * $hargaInput;
        }

        $this->jumlah_anggaran = $total;
    }


        public function update()
        {
            $this->validate([
                'tim_id' => 'required|exists:tpks,id',
                'jumlah_anggaran' => 'required|numeric|max:' . $this->paketPekerjaan->pagu_pak,
                'paket_type' => 'required',
                'spek_teknis' => 'nullable|file|mimes:pdf,doc,docx',
                'kak' => 'nullable|file|mimes:pdf,doc,docx',
                'jadwal_pelaksanaan' => 'nullable|file|mimes:pdf,doc,docx',
                'rencana_kerja' => 'nullable|file|mimes:pdf,doc,docx',
                'hps' => 'nullable|file|mimes:pdf,doc,docx',
            ]);

            // Validasi stok/sisa qty
            foreach ($this->selectedRincian as $rinciId) {
                $qty = $this->quantities[$rinciId] ?? 1;
                $rincian = PaketPekerjaanRinci::find($rinciId);

                $jumlahDibelanjakan = PaketKegiatanRinci::where('paket_pekerjaan_rinci_id', $rinciId)
                    ->where('paket_kegiatan_id', '!=', $this->paketKegiatan->id)
                    ->sum('quantity');

                $available = $rincian->jml_satuan_pak - $jumlahDibelanjakan;
                $terkait = $this->paketKegiatan->rincian->contains('paket_pekerjaan_rinci_id', $rinciId);

                if ($qty > $available && !$terkait) {
                    $this->addError('quantities.' . $rinciId, 'Jumlah melebihi sisa tersedia.');
                    return;
                }
            }

            DB::beginTransaction();
            try {
                // Update data utama
                $this->paketKegiatan->jumlah_anggaran = $this->jumlah_anggaran;
                $this->paketKegiatan->tim_id = $this->tim_id;
                $this->paketKegiatan->paket_type = $this->paket_type;

                if ($this->spek_teknis) {
                    $this->deleteOldFile($this->paketKegiatan->spek_teknis);
                    $this->paketKegiatan->spek_teknis = $this->spek_teknis->store('dokumen/spek_teknis');
                }

                if ($this->kak) {
                    $this->deleteOldFile($this->paketKegiatan->kak);
                    $this->paketKegiatan->kak = $this->kak->store('dokumen/kak');
                }

                if ($this->jadwal_pelaksanaan) {
                    $this->deleteOldFile($this->paketKegiatan->jadwal_pelaksanaan);
                    $this->paketKegiatan->jadwal_pelaksanaan = $this->jadwal_pelaksanaan->store('dokumen/jadwal');
                }

                if ($this->rencana_kerja) {
                    $this->deleteOldFile($this->paketKegiatan->rencana_kerja);
                    $this->paketKegiatan->rencana_kerja = $this->rencana_kerja->store('dokumen/rencana');
                }

                if ($this->hps) {
                    $this->deleteOldFile($this->paketKegiatan->hps);
                    $this->paketKegiatan->hps = $this->hps->store('dokumen/hps');
                }

                // Simpan perubahan awal
                $this->paketKegiatan->save();

                // Hapus dan input ulang rincian kegiatan
                // $this->paketKegiatan->rincian()->delete();
                 PaketKegiatanRinci::where('paket_kegiatan_id', $this->paketKegiatan->id)->delete();
                foreach ($this->selectedRincian as $rinciId) {
                    PaketKegiatanRinci::create([
                        'paket_kegiatan_id' => $this->paketKegiatan->id,
                        'paket_pekerjaan_rinci_id' => $rinciId,
                        'quantity' => $this->quantities[$rinciId] ?? 1,
                        'harga' => $this->hargas[$rinciId] ?? 0, // harga input user
                    ]);
                }

                // Update total quantity dan status use_st
                $paketRincis = PaketPekerjaanRinci::where('paket_pekerjaan_id', $this->paketPekerjaan->id)->get();
                foreach ($paketRincis as $rinci) {
                    $jumlahTotal = PaketKegiatanRinci::where('paket_pekerjaan_rinci_id', $rinci->id)->sum('quantity');
                    $rinci->quantity = $jumlahTotal;
                    $rinci->use_st = $jumlahTotal > 0;
                    $rinci->save();
                }

                // Hitung ulang jumlah anggaran berdasarkan rincian setelah update
                $this->paketKegiatan->load('rincian');

                $total = 0;
                foreach ($this->paketKegiatan->rincian as $rinci) {
                    $harga = $rinci->pivot->harga ?? 0; // harga input user (pivot)
                    $qty = $rinci->pivot->quantity ?? 0;
                    $total += $qty * $harga;
                }

                $this->paketKegiatan->jumlah_anggaran = $total;
                $this->paketKegiatan->save();

                DB::commit();

                session()->flash('message', 'Dokumen berhasil diperbarui.');
                $route = route('desa.paket-kegiatan', ['paketPekerjaanId' => $this->paketPekerjaan->id]);

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
            } catch (\Exception $e) {
                DB::rollBack();
                // Tambah pesan error/debug sesuai kebutuhan
                session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
                throw $e;
            }
        }


    protected function deleteOldFile($path)
    {
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public function render()
    {
        $this->hitungAnggaran();
        return view('livewire.desa.paket-kegiatan-edit');
    }
}
