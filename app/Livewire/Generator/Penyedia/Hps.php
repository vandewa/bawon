<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\HargaPerkiraanSendiri;
use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;

class Hps extends Component
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
            $this->cekData = HargaPerkiraanSendiri::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {
            // Jika belum ada, buat template default
            $this->isiSurat = <<<HTML
            <p style="text-align:center; line-height:150%; font-size:10pt;"><strong><span style="font-family:Arial;"><b>HARGA PERKIRAAN SENDIRI</b></span></strong></p>
            <p style="text-align:center; font-size:10pt;"><span style="font-family:Arial;">
                Pekerjaan {$this->paketPekerjaan->nama_kegiatan}<br> 
                Desa {$this->paketPekerjaan->desa->name}<br>
                Tahun {$this->paketPekerjaan->tahun}
            </span></p>
           
            <table style="width:100%; font-family:Arial; font-size:10pt; border:1pt solid #000; border-collapse:collapse;" cellpadding="5">
            <thead>
                <tr style="text-align:center;">
                    <th style="border:1pt solid #000;">No</th>
                    <th style="border:1pt solid #000;">Uraian Kegiatan/ Nama barang/jasa*</th>
                    <th style="border:1pt solid #000;">Spesifikasi</th>
                    <th style="border:1pt solid #000;">Volume</th>
                    <th style="border:1pt solid #000;">Satuan</th>
                    <th style="border:1pt solid #000;">Harga Satuan (Rp)</th>
                    <th style="border:1pt solid #000;">Jumlah Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
            <tr style="font-size: 8pt; font-style: italic;">
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">a</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">b</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">c</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">d</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">e</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">f</p>
                </td>
                <td style="border:1pt solid #000;">
                    <p style="margin: 0;text-align:center;">g</p>
                </td>
            </tr>

                <tr>
                    <td style="border:1pt solid #000;">\${no}.</td>
                    <td style="border:1pt solid #000;">\${uraian}</td>
                    <td style="border:1pt solid #000;">\${spesifikasi}</td>
                    <td style="border:1pt solid #000;">\${volume}</td>
                    <td style="border:1pt solid #000;">\${satuan}</td>
                    <td style="border:1pt solid #000;">\${hrg_satuan}</td>
                    <td style="border:1pt solid #000;">\${jml_satuan}</td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Jumlah Harga</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;">&nbsp;&nbsp;\${jml_harga}</td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">PPN (%)</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Total Harga</td>
                    <td style="border:1pt solid #000;margin:0;padding:0;">&nbsp;&nbsp;\${total_harga}</td>
                </tr>
            </tbody>
            </table>
            <span style=" font-family: Arial, sans-serif; font-size:8pt;">
            <i>*) pilih salah satu </i>
            </span> 

        
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
                        {$this->paketPekerjaan->nm_pptkd}
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
            HargaPerkiraanSendiri::where('paket_kegiatan_id', $paketId)->update([
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        } else {
            // Simpan data baru
            HargaPerkiraanSendiri::create([
                'paket_kegiatan_id' => $paketId,
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        }

        $this->sudahDisimpan = true;
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.hps');
    }
}
