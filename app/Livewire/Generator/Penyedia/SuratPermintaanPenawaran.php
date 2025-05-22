<?php

namespace App\Livewire\Generator\Penyedia;

use App\Models\Generator\SuratPenawaran;
use Livewire\Component;
use App\Models\PaketKegiatan;
use App\Models\PaketPekerjaan;
use App\Models\Vendor;
use Carbon\Carbon;


class SuratPermintaanPenawaran extends Component
{
    public string $isiSurat;
    public bool $sudahDisimpan = true;
    public $paketPekerjaan;
    public $paketKegiatan;
    public $vendorId;
    public $cekData;
    public $tgl_pemasukan, $tgl_evaluasi, $tgl_negosiasi;
    public $paling_lambat;
    public $jangka_waktu;

    public function formatHariTanggal($datetime)
    {

        if (!$datetime) return '______________';
        $carbon = Carbon::parse($datetime);
        $hari = $carbon->translatedFormat('l'); // Kamis
        $tanggal = $carbon->translatedFormat('d F Y'); // 23 Mei 2024
        return $hari . ', ' . $tanggal;
    }

    // Format pukul: 08:30 WIB
    public function formatJam($datetime)
    {

        if (!$datetime) return '______________';
        return Carbon::parse($datetime)->format('H:i') . ' WIB';
    }

    public function mount($paketKegiatan, $vendorId)
    {
           Carbon::setLocale('id');
        $this->paketKegiatan = PaketKegiatan::with(['paketPekerjaan.desa'])->find($paketKegiatan);

        $this->vendorId = Vendor::find($vendorId);

        if ($this->paketKegiatan) {
            $this->cekData = SuratPenawaran::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        // dd($this->paketKegiatan);

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
       // Isi property tanggal jika data sudah ada
        if ($this->cekData) {

            $this->tgl_pemasukan = $this->cekData->tgl_pemasukan;
            $this->tgl_evaluasi = $this->cekData->tgl_evaluasi;
            $this->tgl_negosiasi = $this->cekData->tgl_negosiasi;
            $this->paling_lambat = $this->cekData->paling_lambat;
            $this->jangka_waktu = $this->cekData->jangka_waktu??0;

        } else {
        // Default: null (atau isi default jika mau)
            $this->tgl_pemasukan = null;
            $this->tgl_evaluasi = null;
            $this->tgl_negosiasi = null;
        }
            $hari_ini = formatTanggalIndonesia();

            $nilaiAngka = $this->paketKegiatan->jumlah_anggaran ?? 0;

            // Format rupiah
            $nilaiRupiah = 'Rp ' . number_format($nilaiAngka, 0, ',', '.');

            // Pakai helper terbilang (anggap sudah tersedia)
            $nilaiTerbilang = terbilang($nilaiAngka);

            if ($this->paling_lambat) {
                $carbon = \Carbon\Carbon::parse($this->paling_lambat);
                $hari = $carbon->translatedFormat('l'); // Contoh: Senin
                $tanggal = $carbon->translatedFormat('d F Y'); // Contoh: 27 Mei 2024
                $jam = $carbon->format('H:i'); // Contoh: 09:00
            } else {
                $hari = '_______________';
                $tanggal = '_______________';
                $jam = '_______________';
            }
            $jangkaWaktu = $this->jangka_waktu;
            $jangkaWaktuTerbilang = $jangkaWaktu ? terbilang($jangkaWaktu) : '_______________';

           $a = <<<HTML
            <div style="font-family:Arial; font-size:10pt;">

                <p style="text-align:center;"><strong>[Kop Surat TPK/Desa]</strong></p>

                <table class="no-border" style="width:100%; border:0; font-size:10pt; font-family:Arial; border-collapse:collapse; line-height:1;">
                    <tr style="line-height:1; vertical-align:top;">
                        <td style="width:15%; padding:0; margin:0; line-height:1; vertical-align:top;">Nomor</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">:</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">__________________________</td>
                        <td style="text-align:right; padding:0; margin:0; line-height:1; vertical-align:top;" colspan="2">Wonosobo, {$hari_ini}</td>
                    </tr>
                    <tr style="line-height:1; vertical-align:top;">
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">Lampiran</td>
                        <td style="padding:0; margin:0; line-height:1; vertical-align:top;">:</td>
                        <td colspan="3" style="padding:0; margin:0; line-height:1; vertical-align:top;"></td>
                    </tr>
                </table>

                <br>

                <p style="margin: 0;">Kepada Yth.</p>
                <p style="margin: 0;"><i>Dir/Pemilik Perusahaan/Toko*</i></p>
                <p style="margin: 0;">{$this->vendorId->nama_perusahaan}</p>
                <p style="margin: 0;">di Tempat</p>


                <p>Perihal: Permintaan Penawaran Pekerjaan</p>

                <p>
                    Tim Pelaksana Kegiatan (TPK) {$this->paketKegiatan->paketPekerjaan->desa->name} Tahun {$this->paketKegiatan->paketPekerjaan->tahun}, dengan ini mengundang Toko/BUMDes/CV/Pemasok* Saudara untuk mengikuti proses pengadaan barang/jasa dengan cara permintaan penawaran tertulis untuk pekerjaan:
                </p>

                <table class="no-border" style="width:100%; border:0;font-size:10pt; font-family:Arial;">
                    <tr>
                        <td style="margin:0; padding:0;">1.</td>
                        <td style="margin:0; padding:0;">Nama Pekerjaan</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">{$this->paketKegiatan->paketPekerjaan->nama_kegiatan}</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Lingkup pekerjaan</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">Terlampir</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Spesifikasi Teknis*</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;"></td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Nilai total HPS</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">{$nilaiRupiah} ({$nilaiTerbilang})</td>
                    </tr>
                    <tr>
                        <td style="margin:0; padding:0;"></td>
                        <td style="margin:0; padding:0;">Sumber Dana</td>
                        <td style="margin:0; padding:0;">:</td>
                        <td style="margin:0; padding:0;">APBDesa Tahun Anggaran {$this->paketKegiatan->paketPekerjaan->tahun}</td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">2.</td>
                        <td colspan="3" style="text-align:justify;">
                            Kami harapkan penawaran tertulis dari Saudara dan Surat Pernyataan Kebenaran Usaha dapat disampaikan kepada Tim Pelaksana Kegiatan (TPK) Desa {$this->paketKegiatan->paketPekerjaan->desa->name} beralamat di {$this->paketKegiatan->paketPekerjaan->desa->alamat}, paling lambat pada hari {$hari} tanggal {$tanggal} Pukul {$jam} WIB.
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">3.</td>
                        <td colspan="3">
                            Jangka waktu pelaksanaan pekerjaan selama {$jangkaWaktu} ( {$jangkaWaktuTerbilang} ) hari kalender.
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">4.</td>
                        <td colspan="3">
                            Jadwal pelaksanaan kegiatan pengadaan barang/jasa dengan cara Permintaan Penawaran selengkapnya sebagai berikut:
                        </td>
                    </tr>

                </table>

                <table border="1" style="width:100%; border-collapse:collapse; text-align:center;font-size:10pt; font-family:Arial;">
                        <thead>
                            <tr>
                                <th style="width:5%;" rowspan="2">No</th>
                                <th style="width:30%;" rowspan="2">Kegiatan</th>
                                <th style="width:35%;" colspan="3">Pelaksanaan Pengadaan </th>
                                <th style="width:30%;" rowspan="2">Keterangan</th>
                            </tr>
                            <tr>
                                <th style="width:20%;">Hari/Tanggal</th>
                                <th style="width:15%;">Pukul</th>
                                <th style="width:15%;">Tempat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Pemasukan dan Pembukaan Dokumen Penawaran</td>
                                <td>{$this->formatHariTanggal($this->tgl_pemasukan)}</td>
                                <td>{$this->formatJam($this->tgl_pemasukan)}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Evaluasi Teknis dan Biaya</td>
                                <td>{$this->formatHariTanggal($this->tgl_evaluasi)}</td>
                                <td>{$this->formatJam($this->tgl_evaluasi)}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Negosiasi Harga</td>
                                <td>{$this->formatHariTanggal($this->tgl_negosiasi)}</td>
                                <td>{$this->formatJam($this->tgl_negosiasi)}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                <p style="font-size:10pt; font-family:Arial;">Demikian surat Permintaan Penawaran ini kami buat, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
                <p style="font-size:7pt; font-family:Arial; font-style:italic;">*) coret yang tidak perlu</p>

                <table class="no-border" style="width:100%; font-family:Arial; font-size:10pt;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="text-align:center;">
                            An. Tim Pelaksana Kegiatan <br>
                            Desa {$this->paketKegiatan->paketPekerjaan->desa->name}  <br>
                            Tahun Anggaran {$this->paketKegiatan->paketPekerjaan->tahun}   <br>
                            Ketua:<br><br><br><br>
                            tanda tangan, <br>
                            nama lengkap
                        </td>
                    </tr>
                </table>

            </div>
        HTML;

        if($this->cekData->isi_surat??"" == ""){
            $this->isiSurat = $a;
        }


    }


    public function simpan()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;

        if ($this->cekData) {
            // Update ke database
            SuratPenawaran::where('paket_kegiatan_id', $paketId)->update([
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        } else {
            // Simpan data baru
            SuratPenawaran::create([
                'paket_kegiatan_id' => $paketId,
                'isi_surat' => $this->isiSurat, // HTML
            ]);
        }

        $this->sudahDisimpan = true;
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function simpanTanggal()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;

        $dataTanggal = [
            'tgl_pemasukan' => $this->tgl_pemasukan,
            'tgl_evaluasi'  => $this->tgl_evaluasi,
            'tgl_negosiasi' => $this->tgl_negosiasi,
            'paling_lambat' => $this->paling_lambat,
            'jangka_waktu' => $this->jangka_waktu,
        ];

        $this->validate([
            'tgl_pemasukan' => 'nullable|date',
            'tgl_evaluasi'  => 'nullable|date',
            'tgl_negosiasi' => 'nullable|date',
            'paling_lambat' => 'nullable|date',
            'jangka_waktu' => 'nullable|integer|min:1',
        ]);

        // Update jika sudah ada, atau create jika belum ada (tanpa isi_surat)
        if ($this->cekData) {
            SuratPenawaran::where('paket_kegiatan_id', $paketId)->update($dataTanggal);
        } else {
            $dataTanggal['paket_kegiatan_id'] = $paketId;
            SuratPenawaran::create($dataTanggal);
        }

        session()->flash('message', 'Tanggal jadwal berhasil disimpan!');
        // Refresh cekData agar Livewire tahu data sudah tersimpan
        $this->cekData = SuratPenawaran::where('paket_kegiatan_id', $paketId)->first();
       return redirect(request()->header('Referer'));
    }


    public function render()
    {
        return view('livewire.generator.penyedia.surat-permintaan-penawaran');
    }
}
