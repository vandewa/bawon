<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\SpesifikasiTeknis as GeneratorSpesifikasiTeknis;
use App\Models\PaketKegiatan;
use Livewire\Component;
use App\Models\PaketPekerjaan;

class SpesifikasiTeknis extends Component
{
    public $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan, $paketKegiatan, $cekData;

    public function mount($id)
    {
        // Mengambil data PaketPekerjaan berdasarkan ID
        $this->paketPekerjaan = PaketPekerjaan::with(['desa', 'paketKegiatans'])->findOrFail($id);

        // Mengambil data PaketKegiatan berdasarkan paket_pekerjaan_id
        $this->paketKegiatan = PaketKegiatan::where('paket_pekerjaan_id', $this->paketPekerjaan->id)->first();

        // Cek apakah data GeneratorSpesifikasiTeknis sudah ada
        if ($this->paketKegiatan) {
            $this->cekData = GeneratorSpesifikasiTeknis::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {
            // Jika belum ada, buat template default
            $this->isiSurat = <<<HTML
            <h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold;">
                Spesifikasi Teknis
            </h4>
            
            <p style="font-family: Arial, sans-serif; font-size: 10pt; text-align: center; line-height: 18pt;">
               Paket Pengadaan {$this->paketPekerjaan->nama_kegiatan}<br> 
               Desa {$this->paketPekerjaan->desa->name}<br>
               Tahun {$this->paketPekerjaan->tahun}
            </p>
            
            <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt;">
                <thead style="font-weight: bold;">
                    <tr>
                        <td style="width: 5%; text-align: center;">No</td>
                        <td style="width: 35%; text-align: center;">Deskripsi Barang/Jasa</td>
                        <td style="width: 10%; text-align: center;">Volume</td>
                        <td style="width: 10%; text-align: center;">Satuan</td>
                        <td style="width: 40%; text-align: center;">Spesifikasi</td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-size: 8pt; font-style: italic;">
                        <td style="text-align: center;">a</td>
                        <td style="text-align: center;">b</td>
                        <td style="text-align: center;">c</td>
                        <td style="text-align: center;">d</td>
                        <td style="text-align: center;">e</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">1.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">2.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">3.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">dst.</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
            <br><br>
            
            <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt;border: none; border-collapse: collapse;">
                <tr>
                    <td style="width: 60%;"></td>
                    <td>
                        <span style="font-weight:bold;">
                            Kepala Seksi/Kepala Urusan*
                        </span> <br>
                        <span style="font-weight:bold;">
                            Bidang {$this->paketPekerjaan->nama_bidang}
                        </span> <br>
                        <span>
                           <i>*) pilih salah satu </i>
                        </span> <br><br>
    
                        ttd
    
                        <br><br>
    
                        <span style="font-weight:bold;">
                        ({$this->paketPekerjaan->nm_pptkd})
                        </span>
                    </td>
                </tr>
            </table>
            
            HTML;
        }


    }

    public function simpan()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;

        if ($this->cekData) {
            // Update ke database
            GeneratorSpesifikasiTeknis::where('paket_kegiatan_id', $paketId)->update([
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        } else {
            // Simpan data baru
            GeneratorSpesifikasiTeknis::create([
                'paket_kegiatan_id' => $paketId,
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        }

        $this->sudahDisimpan = true;
        session()->flash('message', 'Surat berhasil disimpan!');
    }



    public function render()
    {
        return view('livewire.generator.penyedia.spesifikasi-teknis');
    }
}
