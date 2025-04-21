<?php

namespace App\Livewire\Generator;

use Livewire\Component;

class SpesifikasiTeknisEditor extends Component
{
    public string $isiSurat, $idPaket;

    public function mount()
    {
        $this->isiSurat = <<<HTML
        <h4 style="text-align: center; font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold;">
            Spesifikasi Teknis
        </h4>
        
        <p style="font-family: Arial, sans-serif; font-size: 10pt; text-align: center; line-height: 18pt;">
            <strong>Paket Pengadaan:</strong> \${paket_pengadaan}<br> 
            <strong>Desa:</strong> \${desa}<br>
            <strong>Tahun:</strong> \${tahun}
        </p>


        
        <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10pt; text-align: center;">
            <thead style="font-weight: bold;">
                <tr>
                    <td style="width: 5%;">No</td>
                    <td style="width: 35%;">Deskripsi Barang/Jasa</td>
                    <td style="width: 10%;">Volume</td>
                    <td style="width: 10%;">Satuan</td>
                    <td style="width: 40%;">Spesifikasi</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
        <br><br>
        
        <table class="no-border" style="width: 100%; font-family: Arial, sans-serif; font-size: 10pt; font-weight: bold; border: none; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;"></td>
                <td style="text-align: center;">
                    Kepala Seksi/Kepala Urusan*<br>
                    Bidang \${bidang}<br><br><br><br>
                    (<u>\${nama_lengkap}</u>)
            </td>
            </tr>
        </table>
        
        <p style="font-family: Arial, sans-serif; font-size: 8pt; font-style: italic;">*) pilih salah satu</p>
        HTML;
    }



    public function simpan()
    {
        session()->flash('message', 'Surat berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.generator.spesifikasi-teknis-editor');
    }
}
