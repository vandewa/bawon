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
    public $rincianList = [];
    public $idnya;

    public function mount($id)
    {

        $this->idnya = $id;

        // Mengambil data PaketKegiatan berdasarkan paket_pekerjaan_id
        $this->paketKegiatan = PaketKegiatan::with('rincian')->where('id', $id)->first();

        // Mengambil data PaketPekerjaan berdasarkan ID
        $this->paketPekerjaan = PaketPekerjaan::with(['desa', 'paketKegiatans'])->findOrFail($this->paketKegiatan->paket_pekerjaan_id);

        $this->rincianList = $this->paketKegiatan?->rincian ?? collect();
        
        // Cek apakah data GeneratorSpesifikasiTeknis sudah ada
        if ($this->paketKegiatan) {
            $this->cekData = HargaPerkiraanSendiri::where('paket_kegiatan_id', $this->paketKegiatan->id)->first();
        } else {
            $this->cekData = null;
        }

        $this->isiSurat = $this->getDefaultIsiSurat();

        // Jika data GeneratorSpesifikasiTeknis sudah ada, gunakan isi_surat-nya
        if ($this->cekData) {
            $this->isiSurat = $this->cekData->isi_surat;
        } else {
            // Jika belum ada, buat template default
            $this->isiSurat = $this->getDefaultIsiSurat();
    }
}

    public function getDefaultIsiSurat()
{
    $namaKegiatan = ucwords(strtolower($this->paketPekerjaan->nama_kegiatan ?? ''));
    $namaDesa     = ucwords(strtolower($this->paketPekerjaan->desa->name ?? ''));
    $tahun        = $this->paketPekerjaan->tahun ?? '';
    $namaBidang   = $this->paketPekerjaan->nama_bidang ?? '';
    $nmPptkd      = $this->paketPekerjaan->nm_pptkd ?? '';
    $jumlahAnggaran = $this->paketKegiatan?->jumlah_anggaran ?? 0;

    // Generate rows
    $rows = '';
    $total = 0;
    foreach ($this->rincianList as $i => $rinci) {
        $no = $i + 1;
        $uraian = $rinci->uraian ?? '';
        $spesifikasi = $rinci->spesifikasi ?? '';
        $volume = (float) ($rinci->pivot->quantity ?? 0);
        $satuan = $rinci->satuan ?? '';
        $hrg_satuan = (float) ($rinci->pivot->harga ?? 0);
        $jml_satuan = $hrg_satuan * $volume;
        $total += $jml_satuan;
        $harga = number_format($total, 0, ',', '.'); // dari jumlah_anggaran PaketKegiatan

        $hrg_satuan = number_format($hrg_satuan, 0, ',', '.'); // dari jumlah_anggaran PaketKegiatan

        $rows .= "
        <tr>
            <td style=\"border:1pt solid #000; text-align:center;\">$no</td>
            <td style=\"border:1pt solid #000;\">$uraian</td>
            <td style=\"border:1pt solid #000;\">$spesifikasi</td>
            <td style=\"border:1pt solid #000; text-align:center;\">$volume</td>
            <td style=\"border:1pt solid #000; text-align:center;\">$satuan</td>
            <td style=\"border:1pt solid #000; text-align:right;\">$hrg_satuan</td>
            <td style=\"border:1pt solid #000; text-align:right;\">$harga</td>
        </tr>
        ";
    }

    $total_harga = number_format($jumlahAnggaran, 0, ',', '.'); // dari jumlah_anggaran PaketKegiatan
    $total_detail = number_format($total, 0, ',', '.'); // dari penjumlahan rincian (bisa buat cek juga)

    return <<<HTML
    <p style="text-align:center; line-height:150%; font-size:10pt;">
        <strong><span style="font-family:Arial;"><b>HARGA PERKIRAAN SENDIRI</b></span></strong>
    </p>
    <p style="text-align:center; font-size:10pt;"><span style="font-family:Arial;">
        Pekerjaan {$namaKegiatan}<br>
         {$namaDesa}<br>
        Tahun {$tahun}
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
            $rows
            <tr>
                <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Jumlah Harga</td>
                <td style="border:1pt solid #000;margin:0;padding:0; text-align:right;">$total_harga</td>
            </tr>
            <tr>
                <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">PPN (%)</td>
                <td style="border:1pt solid #000;margin:0;padding:0;"></td>
            </tr>
            <tr>
                <td colspan="6" style="border:1pt solid #000; text-align:right;font-weight: bold;margin:0;padding:0;">Total Harga</td>
                <td style="border:1pt solid #000;margin:0;padding:0; text-align:right;">$total_harga</td>
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
                    {$namaBidang}
                </span> <br>
                <span>
                   <i>*) pilih salah satu </i>
                </span> <br><br>
                ttd
                <br><br>
                <span style="font-weight:bold;">
                {$nmPptkd}
                </span>
            </td>
        </tr>
    </table>
    HTML;
}

    public function resetIsiSurat()
        {
           $this->redirect(request()->header('Referer') ?? url()->current());

            HargaPerkiraanSendiri::where('paket_kegiatan_id', $this->idnya)->delete();
            $this->redirect(request()->header('Referer') ?? url()->current());

        }



    public function simpan()
    {
        $paketId = $this->paketKegiatan['id'] ?? null;


        HargaPerkiraanSendiri::updateOrCreate(
            ['paket_kegiatan_id' => $this->idnya], // Kondisi pencarian
            ['isi_surat' => $this->isiSurat]   // Data yang diupdate/isi baru
        );

        $this->sudahDisimpan = true;
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.penyedia.hps');
    }
}
