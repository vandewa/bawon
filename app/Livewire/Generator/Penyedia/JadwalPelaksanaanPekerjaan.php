<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\JadwalPelaksanaanPekerjaan as GeneratorJadwalPelaksanaanPekerjaan;
use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;

class JadwalPelaksanaanPekerjaan extends Component
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
            $this->cekData = GeneratorJadwalPelaksanaanPekerjaan::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {
            // Jika belum ada, buat template default
            $bidang = strtoupper($this->paketPekerjaan->nama_subbidang);
            $desa = strtoupper($this->paketPekerjaan->desa->name);

            $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
            <p style="text-align: center; margin: 0; text-transform: uppercase;">
                KEPALA SEKSI/KEPALA URUSAN {$bidang}
            </p>
            <p style="text-align: center; margin: 0; text-transform: uppercase;">
                DESA {$desa}
            </p>

                <br>

                <table style="width:100%; border-collapse:collapse; font-size:10pt; font-family:Arial;" border="1">
                    <thead>
                        <tr style="text-align:center;">
                            <th style="width:25%;">Nama Pekerjaan/ Kegiatan</th>
                            <th style="width:25%;">Tim Pelaksana Kegiatan (TPK)</th>
                            <th style="width:25%;">Waktu Pelaksanaan</th>
                            <th style="width:25%;">Nilai Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:center; font-size:8pt; margin:0; padding:0;"><i>a</i></td>
                            <td style="text-align:center; font-size:8pt; margin:0; padding:0;"><i>b</i></td>
                            <td style="text-align:center; font-size:8pt; margin:0; padding:0;"><i>c</i></td>
                            <td style="text-align:center; font-size:8pt; margin:0; padding:0;"><i>d</i></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;">Jumlah waktu ___ (hari/bulan)</td>
                            <td style="text-align:center;"></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;"></td>
                            <td style="text-align:center;">(tanggal/bulan) ___ sampai dengan (tanggal/bulan) ___ tahun _____ </td>
                            <td style="text-align:center;"></td>
                        </tr>
                    </tbody>
                </table>

                <br><br>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            Kasi/Kaur {$this->paketPekerjaan->nama_subbidang}, <br>
                            Desa {$this->paketPekerjaan->desa->name}<br><br><br><br>

                            tanda tangan, <br>
                            {$this->paketPekerjaan->nm_pptkd}
                        </td>
                    </tr>
                </table>
            </div>
        HTML;
        }

    }


    public function simpan()
    {
        // Simpan ke database sebagai HTML
        //  \App\Models\Surat::create([
        //     'judul' => 'Surat dari Summernote',
        //     'isi' => $this->isiSurat, // disimpan dalam format HTML
        // ]);

        $this->sudahDisimpan = true; // aktifkan tombol download setelah simpan
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.jadwal-pelaksanaan-pekerjaan');
    }
}
