<?php

namespace Database\Seeders;

use App\Models\ComCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('com_codes')->truncate();

        $data = [

            ['com_cd' => 'TPK_TYPE_01', 'code_nm' => 'Ketua', 'code_group' => 'TPK_TYPE'],
            ['com_cd' => 'TPK_TYPE_02', 'code_nm' => 'Sekretaris', 'code_group' => 'TPK_TYPE'],
            ['com_cd' => 'TPK_TYPE_03', 'code_nm' => 'Anggota', 'code_group' => 'TPK_TYPE'],
            ['com_cd' => 'KEGIATAN_ST_01', 'code_nm' => 'Terbuka', 'code_group' => 'KEGIATAN_ST'],
            ['com_cd' => 'KEGIATAN_ST_02', 'code_nm' => 'Tertutup', 'code_group' => 'KEGIATAN_ST'],
            ['com_cd' => 'PAKET_KEGIATAN_ST_01', 'code_nm' => 'Pending', 'code_group' => 'PAKET_KEGIATAN_ST', 'code_value' => 'bg-warning'],
            ['com_cd' => 'PAKET_KEGIATAN_ST_02', 'code_nm' => 'Berjalan', 'code_group' => 'PAKET_KEGIATAN_ST', 'code_value' => 'bg-primary'],
            ['com_cd' => 'PAKET_KEGIATAN_ST_03', 'code_nm' => 'Selesai', 'code_group' => 'PAKET_KEGIATAN_ST', 'code_value' => 'bg-success'],
            ['com_cd' => 'PAKET_KEGIATAN_ST_04', 'code_nm' => 'Batal', 'code_group' => 'PAKET_KEGIATAN_ST', 'code_value' => 'bg-danger'],
            ['com_cd' => 'PAKET_TYPE_01', 'code_nm' => 'Penyedia', 'code_group' => 'PAKET_TYPE'],
            ['com_cd' => 'PAKET_TYPE_02', 'code_nm' => 'Swakelola', 'code_group' => 'PAKET_TYPE'],
            ['com_cd' => 'PAKET_TYPE_03', 'code_nm' => 'Lelang', 'code_group' => 'PAKET_TYPE'],
            ['com_cd' => 'PENAWARAN_ST_01', 'code_nm' => 'Review', 'code_group' => 'PENAWARAN_ST'],
            ['com_cd' => 'PENAWARAN_ST_02', 'code_nm' => 'Diterima', 'code_group' => 'PENAWARAN_ST'],
            ['com_cd' => 'PENAWARAN_ST_03', 'code_nm' => 'Ditolak', 'code_group' => 'PENAWARAN_ST'],
            ['com_cd' => 'NEGOSIASI_ST_01', 'code_nm' => 'Berlangsung', 'code_group' => 'NEGOSIASI_ST'],
            ['com_cd' => 'NEGOSIASI_ST_02', 'code_nm' => 'Selesai', 'code_group' => 'NEGOSIASI_ST'],
            ['com_cd' => 'KUALIFIKASI_ST_01', 'code_nm' => 'Kecil', 'code_group' => 'KUALIFIKASI_ST'],
            ['com_cd' => 'KUALIFIKASI_ST_02', 'code_nm' => 'Non Kecil', 'code_group' => 'KUALIFIKASI_ST'],
            ['com_cd' => 'JENIS_USAHA_ST_01', 'code_nm' => 'Jasa', 'code_group' => 'JENIS_USAHA_ST'],
            ['com_cd' => 'JENIS_USAHA_ST_02', 'code_nm' => 'Perdagangan', 'code_group' => 'JENIS_USAHA_ST'],


        ];

        foreach ($data as $item) {
            ComCode::create($item);
        }
    }
}
