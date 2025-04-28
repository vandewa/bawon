<?php

namespace App\Livewire\Generator\Swakelola;

use Livewire\Component;
use App\Models\PaketPekerjaan;

class RencanaAnggaranBiaya extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan;

    public function mount()
    {
        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold;">Rencana Anggaran Biaya</p>
        
                <table style="width:100%; border-collapse:collapse; font-size:10pt; font-family:Arial;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Uraian</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan (Rp)</th>
                            <th>Jumlah (Rp)</th>
                            <th>Jadwal Pekerjaan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>a</td>
                            <td>Tenaga Kerja</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td>Bahan</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td>Peralatan</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align:right; font-weight:bold;">Total Pekerjaan Persiapan</td>
                            <td>Rp</td>
                        </tr>
        
                        <!-- Repeat for other sections -->
                        <tr>
                            <td>a</td>
                            <td>Tenaga Kerja</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td>Bahan</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td>Peralatan</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
        
                        <tr>
                            <td colspan="8" style="text-align:right; font-weight:bold;">Jumlah Total Biaya Pekerjaan</td>
                            <td>Rp</td>
                        </tr>
                    </tbody>
                </table>
        
                <p style="margin-top:20px;">Kepala Seksi/Kepala Urusan* </p>
                <p>Bidang/p>
                <p>nama</p>
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
        return view('livewire.generator.swakelola.rencana-anggaran-biaya');
    }
}
