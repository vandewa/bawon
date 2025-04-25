<?php

namespace App\Livewire\Generator\Penyedia;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class PengumumanPerencanaanPengadaan extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">PENGUMUMAN PERENCANAAN PENGADAAN</p>

                <p style="text-align:center; font-weight:bold;">DESA ______________ KABUPATEN/KOTA WONOSOBO</p>

                <p style="text-align:center; font-weight:bold;">TAHUN ANGGARAN ___________</p>

                <table border="1" style="width:100%; font-size:10pt; font-family:Arial; border-collapse:collapse; margin:0; padding:0;">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th style="width:30%;text-align:center;" rowspan="2">Nama Kegiatan</th>
                            <th style="width:20%;text-align:center;" rowspan="2">Nilai Pengadaan (Rp)</th>
                            <th style="width:15%;text-align:center;" rowspan="2">Cara Pengadaan (Swakelola/ Penyedia)</th>
                            <th style="width:15%;text-align:center;" rowspan="2">Sumber Anggaran</th>
                            <th style="width:30%;text-align:center;" colspan="2">Keluaran/Output</th>
                            <th style="width:10%;text-align:center;" rowspan="2">Nama TPK</th>
                            <th style="width:10%;text-align:center;" rowspan="2">Lokasi Kegiatan</th>
                            <th style="width:10%;text-align:center;" rowspan="2">Waktu Pelaksanaan</th>
                            <th style="width:10%;text-align:center;" rowspan="2">Ket.</th>
                        </tr>
                        <tr>
                            <th style="text-align:center;">Volume</th>
                            <th style="text-align:center;">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>a</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>b</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>c</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>d</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>e</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>f</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>g</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>h</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>i</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>j</i></td>
                            <td style="font-size:8pt;text-align:center;margin:0;padding:0;"><i>k</i></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">1.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">2.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">3.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <p style="font-size:8pt;"><i>*) pilih salah satu</i></p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                    <tr>
                            ______________________ <br><br>
                            <span style="font-weight:bold;">Kepala Desa </span><br><br><br>

                            tanda tangan, <br>
                            nama lengkap
                        </td>
                    </tr>
                </table>
            </div>
            HTML;


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
        return view('livewire.generator.penyedia.pengumuman-perencanaan-pengadaan');
    }
}
