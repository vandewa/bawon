<?php

namespace App\Livewire\Generator\Desa;

use App\Models\Desa;
use Livewire\Component;
use Carbon\Carbon;

class Tpk extends Component
{
    public $isiSurat;
    public bool $sudahDisimpan = false;
    public $paketPekerjaan, $paketKegiatan, $cekData;

    public function mount($desaId, $tahun)
    {

        $desa = Desa::find($desaId);
        $desaupper = strtoupper($desa->name);
        $tanggal = Carbon::now()->isoFormat('DD MMMM YYYY');

        // dd($desa);

        $this->isiSurat = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">
                <p style="text-align:center; font-weight:bold; margin:0;">SURAT KEPUTUSAN KEPALA DESA</p>
                <p style="text-align:center; margin:0;">NOMOR : _____ TAHUN {$tahun}</p>
                <br>

                <p style="text-align:center;margin:0;">
                    TENTANG <br>
                    PENETAPAN TIM PELAKSANA KEGIATAN (TPK) <br>
                    SEBAGAI PELAKSANA PENGADAAN BARANG/JASA <br>
                    PERIODE TAHUN {$tahun} <br>
                </p>
                <br>
                 <p style="text-align:center;margin:0;">
                    KEPALA DESA {$desaupper}
                </p>
                <br>

                <div style="font-family: Arial, sans-serif;">
                    <table class="no-border" style="width: 100%; font-size: 10pt; margin: 0 auto; padding: 0;">
                        <tr>
                            <td style="width: 10%;vertical-align: top;">Menimbang</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 5%;vertical-align: top;">a.</td>
                            <td style="width: 80%;text-align:justify;padding:0;margin:0;">
                                Bahwa untuk kelancaran proses kegiatan pengadaan barang dan jasa yang bersumber dari Anggaran Pendapatan dan Belanja Desa di Desa {$desa->name} serta membantu tugas Kepala Seksi (Kasi) dan Kepala Urusan (Kaur), perlu menetapkan Tim Pelaksana Kegiatan (TPK);
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;vertical-align: top;"></td>
                            <td style="width: 5%;vertical-align: top;"></td>
                            <td style="width: 5%;vertical-align: top;">b.</td>
                            <td style="width: 80%;text-align:justify;padding:0;margin:0;">
                                Bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, maka dipandang perlu menetapkan Surat Keputusan Kepala Desa {$desa->name} Kecamatan _________ Kabupaten/Kota Wonosobo tentang Penetapan Tim Pelaksana Kegiatan (TPK) sebagai pelaksana pengadaan barang/jasa periode tahun ${tahun}.
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;vertical-align: top;">Mengingat</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td colspan="2">
                               (diisi dengan peraturan perundang-undangan terkait pelaksanaan pengadaan barang/jasa di desa)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:center;">MEMUTUSKAN</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;vertical-align: top;">Menetapkan</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td colspan="2">
                               Keputusan Kepala Desa {$desa->name} tentang Penetapan Tim Pelaksana Kegiatan (TPK) Pengadaan Barang/Jasa Desa {$desa->name} Tahun {$tahun}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;vertical-align: top;">KESATU</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td colspan="2">
                               Menetapkan nama-nama terlampir sebagai Tim Pelaksana Kegiatan (TPK) Pemerintah Desa {$desa->name} untuk Tahun Anggaran ${tahun}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 10%;vertical-align: top;">KEDUA</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td colspan="2">
                               Tim Pelaksana Kegiatan (TPK) sebagaimana dimaksud dalam Diktum Kesatu keputusan ini memiliki tugas*: <br>
                                1. ______________ <br>
                                2. ______________ <br>
                                3. dst
                            </td>
                        </tr>
                         <tr>
                            <td style="width: 10%;vertical-align: top;">KETIGA</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td colspan="2">
                              Keputusan ini mulai berlaku sejak tanggal ditetapkan.
                            </td>
                        </tr>
                    </table>
          
                  
                    <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt; border: none; border-collapse: collapse;">
                        <tr>
                            <td style="width: 60%;"></td>
                            <td>
                              Ditetapkan di : ____________
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 60%;"></td>
                            <td>
                             Tanggal : {$tanggal}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 60%;"></td>
                            <td>
                                <span style="font-weight: bold;">
                                    Kepala Desa
                                </span>
                                <br><br><br><br>

                                <span style="font-weight: bold;">
                                    Nama lengkap
                                </span>
                            </td>
                        </tr>
                    </table>

                </div>




            </div>
        HTML;


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
        return view('livewire.generator.desa.tpk');
    }
}
