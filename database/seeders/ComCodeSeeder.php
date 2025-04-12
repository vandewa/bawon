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
            ['com_cd' => 'PENGAJUAN_TP_01', 'code_nm' => 'Di Kantor', 'code_group' => 'PENGAJUAN_TP', 'code_value' => ''],
            ['com_cd' => 'PENGAJUAN_TP_02', 'code_nm' => 'Di Lokasi Alat', 'code_group' => 'PENGAJUAN_TP', 'code_value' => 'Hanya diperuntukkan untuk alat yang tidak bisa dipindah'],
            ['com_cd' => 'PENGAJUAN_ST_01', 'code_nm' => 'Menunggu Persetujuan', 'code_group' => 'PENGAJUAN_ST', 'code_value' => ''],
            ['com_cd' => 'PENGAJUAN_ST_02', 'code_nm' => 'Proses Pemeriksaan', 'code_group' => 'PENGAJUAN_ST', 'code_value' => ''],
            ['com_cd' => 'PENGAJUAN_ST_03', 'code_nm' => 'Ditolak', 'code_group' => 'PENGAJUAN_ST', 'code_value' => ''],
            ['com_cd' => 'PENGAJUAN_ST_04', 'code_nm' => 'Proses Penandatanganan', 'code_group' => 'PENGAJUAN_ST', 'code_value' => ''],
            ['com_cd' => 'PENGAJUAN_ST_05', 'code_nm' => 'Selesai', 'code_group' => 'PENGAJUAN_ST', 'code_value' => ''],
            ['com_cd' => 'HASIL_ST_01', 'code_nm' => 'Sah', 'code_group' => 'HASIL_ST', 'code_value' => 'Disahkan'],
            ['com_cd' => 'HASIL_ST_02', 'code_nm' => 'Batal', 'code_group' => 'HASIL_ST', 'code_value' => 'Dibatalkan'],
            ['com_cd' => 'HASIL_ST_03', 'code_nm' => 'Reparasi', 'code_group' => 'HASIL_ST', 'code_value' => 'Direparasi'],
            ['com_cd' => 'PERALATAN_ST_01', 'code_nm' => 'Tersedia', 'code_group' => 'PERALATAN_ST', 'code_value' => ''],
            ['com_cd' => 'PERALATAN_ST_02', 'code_nm' => 'Dipinjam', 'code_group' => 'PERALATAN_ST', 'code_value' => ''],
            ['com_cd' => 'PERALATAN_ST_03', 'code_nm' => 'Rusak', 'code_group' => 'PERALATAN_ST', 'code_value' => ''],
            ['com_cd' => 'JADWAL_TERA_ST_01', 'code_nm' => 'Aktif', 'code_group' => 'JADWAL_TERA_ST', 'code_value' => ''],
            ['com_cd' => 'JADWAL_TERA_ST_02', 'code_nm' => 'Non Aktif', 'code_group' => 'JADWAL_TERA_ST', 'code_value' => ''],
            ['com_cd' => 'KEMBALI_ST_01', 'code_nm' => 'Tersedia', 'code_group' => 'KEMBALI_ST', 'code_value' => ''],
            ['com_cd' => 'KEMBALI_ST_02', 'code_nm' => 'Dipinjam', 'code_group' => 'KEMBALI_ST', 'code_value' => ''],
            ['com_cd' => 'JENIS_DOKUMEN_TP_01', 'code_nm' => 'SKHP', 'code_group' => 'JENIS_DOKUMEN_TP'],
            ['com_cd' => 'JENIS_DOKUMEN_TP_02', 'code_nm' => 'Kartu Order', 'code_group' => 'JENIS_DOKUMEN_TP'],

        ];

        foreach ($data as $item) {
            ComCode::create($item);
        }
    }
}
