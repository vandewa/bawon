<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Penawaran;
use App\Models\Negoisasi;
use App\Models\PaketKegiatan;
use Illuminate\Support\Facades\DB;

class PenawaranList extends Component
{
    use WithFileUploads;

    public $penawaranId;
    public $baEvaluasi;
    public $isModalOpen = false;
    public $paketKegiatanId;
    public $isNegotiationExist = false;


    public function openModal($penawaranId)
    {
        $this->penawaranId = $penawaranId;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset('baEvaluasi');
    }

    public function simpanEvaluasi()
    {
        $penawaran = Penawaran::with('paketKegiatan')->findOrFail($this->penawaranId);
        $jumlahAnggaran = $penawaran->paketKegiatan->jumlah_anggaran;

        if ($jumlahAnggaran < 10000000) {
            DB::beginTransaction();
            try {
                $penawaran->update(['penawaran_st' => 'PENAWARAN_ST_02']);

                Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
                    ->where('id', '!=', $penawaran->id)
                    ->update(['nilai_kesepakatan' =>   $jumlahAnggaran ]);

                PaketKegiatan::where('id', $penawaran->paket_kegiatan_id)
                    ->update(['kegiatan_st' => 'KEGIATAN_ST_02']);

                Negoisasi::create([
                    'paket_kegiatan_id' => $penawaran->paket_kegiatan_id,
                    'vendor_id' => $penawaran->vendor_id,
                    'nilai' =>   $jumlahAnggaran ,
                    'negosiasi_st' => 'NEGOSIASI_ST_02',
                    'ba_negoisasi' => null,
                ]);

                DB::commit();
                $this->closeModal();

                $this->js(<<<'JS'
                    Swal.fire({
                        icon: 'success',
                        title: 'Disetujui!',
                        text: 'Penawaran disetujui tanpa BA. Negosiasi otomatis disetujui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                JS);
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
                session()->flash('error', 'Terjadi kesalahan. Silakan coba lagi.');
            }
        } else {
            $this->validate([
                'baEvaluasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            DB::beginTransaction();
            try {
                $path = $this->baEvaluasi->store('evaluasi/ba_evaluasi');

                $penawaran->update(['penawaran_st' => 'PENAWARAN_ST_02']);

                Penawaran::where('paket_kegiatan_id', $penawaran->paket_kegiatan_id)
                    ->where('id', '!=', $penawaran->id)
                    ->update(['penawaran_st' => 'PENAWARAN_ST_03']);

                PaketKegiatan::where('id', $penawaran->paket_kegiatan_id)
                    ->update(['ba_evaluasi_penawaran' => $path]);

                Negoisasi::create([
                    'paket_kegiatan_id' => $penawaran->paket_kegiatan_id,
                    'vendor_id' => $penawaran->vendor_id,
                    'nilai' => null,
                    'negosiasi_st' => 'NEGOSIASI_ST_01',
                    'ba_negoisasi' => null,
                ]);

                DB::commit();
                $this->closeModal();

                $this->js(<<<'JS'
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Penawaran dan BA Evaluasi berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                JS);
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    public function render()
    {
        $penawarans = Penawaran::with(['vendor', 'evaluasi'])
            ->where('paket_kegiatan_id', $this->paketKegiatanId)
            ->whereNotNull('dok_penawaran')
            ->get();

        return view('livewire.components.penawaran-list', compact('penawarans'));
    }
}
