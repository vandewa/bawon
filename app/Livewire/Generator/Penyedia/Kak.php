<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\KerangkaAcuanKerja;
use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;

class Kak extends Component
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
            $this->cekData = KerangkaAcuanKerja::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {
            $format_rupiah = format_rupiah($this->paketKegiatan->jumlah_anggaran);
            $terbilang = ucwords(terbilang($this->paketKegiatan->jumlah_anggaran)) . ' Rupiah';
            // Jika belum ada, buat template default
            $this->isiSurat = <<<HTML
                <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><strong><span style="font-family:Arial;"><b>Kerangka Acuan Kerja (KAK)</b></span></strong></p>
                <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Paket Pengadaan {$this->paketPekerjaan->nama_kegiatan}</span></p>
                <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Desa {$this->paketPekerjaan->desa->name}</span></p>
                <p style="margin-top:0pt; margin-bottom:8pt; text-align:center; line-height:116%; font-size:10pt;"><span style="font-family:Arial;">Tahun {$this->paketPekerjaan->tahun}</span></p><br>
                
                <table style="width: 100%; font-family: Arial; font-size: 10pt; border-collapse: collapse;" border="1" cellpadding="5">
                    <thead style="background-color: #d9e2f3; text-align: center;">
                        <tr>
                            <th colspan="3">Uraian Pendahuluan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:2%; font-weight: bold;">1.</td>
                            <td style="width:20%; font-weight: bold;">Latar Belakang</td>
                            <td style="width:78%;">(diisi dengan latar belakang perlunya pekerjaan dilaksanakan)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">2.</td>
                            <td style="font-weight: bold;">Maksud dan Tujuan</td>
                            <td>
                                <table class="no-border" style="width:100%; font-family: Arial; font-size: 10pt;" border="0">
                                    <tr>
                                        <td style="width:70px;">Maksud</td>
                                        <td style="width:10px;">:</td>
                                        <td>(diisi dengan maksud dilaksanakannya pekerjaan)</td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan</td>
                                        <td>:</td>
                                        <td>(diisi dengan tujuan yang ingin dicapai dari pelaksanaan pekerjaan ini, biasanya berhubungan dengan pembangunan desa)</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">3.</td>
                            <td style="font-weight: bold;">Sasaran / Output</td>
                            <td>(diisi dengan hasil akhir dari pekerjaan disertai dengan satuan. Contoh: 1 (satu)
                            bangunan saung pertemuan)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">4.</td>
                            <td style="font-weight: bold;">Lokasi Pengerjaan</td>
                            <td>(diisi nama jalan, tempat, atau posisi pekerjaan dilakukan)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">5.</td>
                            <td style="font-weight: bold;">Sumber Pendanaan</td>
                            <td>Pekerjaan ini dibiayai dari sumber pendanaan: {$this->paketPekerjaan->sumberdana}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">6.</td>
                            <td style="font-weight: bold;">Nilai Pekerjaan</td>
                            <td>{$format_rupiah} ({$terbilang})</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">7.</td>
                            <td style="font-weight: bold;">Kode Rekening</td>
                            <td>{$this->paketPekerjaan->kd_keg}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">8.</td>
                            <td style="font-weight: bold;">Kasi / Kaur</td>
                            <td>
                                <table class="no-border" style="width:100%; font-family: Arial; font-size: 10pt;" border="0">
                                    <tr>
                                        <td style="width:70px;">Nama</td>
                                        <td style="width:10px;">:</td>
                                        <td>{$this->paketPekerjaan->nm_pptkd}</td>
                                    </tr>
                                    <tr>
                                        <td>Bidang</td>
                                        <td>:</td>
                                        <td>{$this->paketPekerjaan->nama_bidang}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">9.</td>
                            <td style="font-weight: bold;">TPK</td>
                            <td>Ketua : <br>
                                Sekretaris : <br>
                                Anggota : <br>
                                1. <br>
                                2. <br>
                                3. <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">10.</td>
                            <td style="font-weight: bold;">Lingkup Pekerjaan</td>
                            <td>(diisi dengan komponen, tahapan pekerjaan)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">11.</td>
                            <td style="font-weight: bold;">Spesifikasi Teknis</td>
                            <td>(diisi dengan spesifikasi sumber daya yang dibutuhkan: SDM, material/bahan,
                            peralatan yang dibutuhkan)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">12.</td>
                            <td style="font-weight: bold;"> Peralatan, Material, Personel dan Fasilitas dari Kasi/Kaur </td>
                            <td>(diisi dengan peralatan, material, personel dan fasilitas yang tercatat/dikuasai desa yang akan digunakan pada pelaksanaan pekerjaan ini)</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">13.</td>
                            <td style="font-weight: bold;">Jangka Waktu Penyelesaian Pekerjaan</td>
                            <td>Pengadaan ini dilaksanakan selama ________ hari kalender/bulan.</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">14.</td>
                            <td style="font-weight: bold;">Jadwal Pelaksanaan Pekerjaan</td>
                            <td>Pengadaan ini dilaksanakan sesuai dengan jadwal (bentuk
                                tabel) (diisi dengan tahapan kegiatan, volume/durasi waktu yang dibutuhkan per tahapan kegiatan, satuan waktu/keterangan)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center; font-weight: bold; background-color: #d9e2f3;">Laporan</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">15.</td>
                            <td style="font-weight: bold;">Laporan Kemajuan Pelaksanaan Pekerjaan</td>
                            <td>
                                Laporan kemajuan pelaksanaan pekerjaan: _____________<br>
                                Laporan harus diserahkan selambat-lambatnya: (______________) *hari/bulan sejak pekerjaan dimulai sebanyak ___________ laporan. <br>
                                *pilih salah satu <br>
                                (diisi dengan penyampaian laporan kemajuan pelaksanaan. Misalnya: pada
                                pekerjaan konstruksi: laporan pembangunan pondasi bangunan pada pengadaan
                                jasa: laporan tanggapan KAK, hasil studi awal)
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">16.</td>
                            <td style="font-weight: bold;">Laporan pelaksanaan pengadaan yang telah selesai 100%</td>
                            <td>
                                Laporan pelaksanaan pengadaan: _____________<br>
                                Laporan harus diserahkan selambat-lambatnya: (______________) *hari/bulan sejak selesainya pekerjaan 100%, sebanyak __________ laporan. <br>
                                *pilih salah satu <br>
                                (diisi dengan penyampaian laporan pelaksanaan pengadaan yang telah selesai)
                            </td>
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
            KerangkaAcuanKerja::where('paket_kegiatan_id', $paketId)->update([
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        } else {
            // Simpan data baru
            KerangkaAcuanKerja::create([
                'paket_kegiatan_id' => $paketId,
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        }


        $this->sudahDisimpan = true; // aktifkan tombol download setelah simpan
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.kak');
    }
}
