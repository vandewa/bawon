<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\PaketPekerjaan;
use App\Models\PaketPekerjaanRinci;

class SyncAnggaranRinci extends Command
{
    protected $signature = 'sync:anggaran-rinci';
    protected $description = 'Sinkronisasi data Ta_AnggaranRinci dari MSSQL ke MySQL (hanya KdPosting terbesar)';

    public function handle()
    {
        $this->info('🚀 Mulai sinkronisasi data rincian...');

        // Ambil nilai KdPosting terbesar
        $maxKdPosting = DB::connection('sqlsrv')->table('Ta_AnggaranRinci')->max('KdPosting');

        DB::connection('sqlsrv')->table('Ta_AnggaranRinci')
            ->leftJoin('Ref_Rek4', 'Ta_AnggaranRinci.Kd_Rincian', '=', 'Ref_Rek4.Obyek')
            ->select(
                'Ta_AnggaranRinci.KdPosting',
                'Ta_AnggaranRinci.Tahun',
                'Ta_AnggaranRinci.Kd_Desa',
                'Ta_AnggaranRinci.Kd_Keg',
                'Ta_AnggaranRinci.Kd_Rincian',
                'Ref_Rek4.nama_obyek',
                'Ta_AnggaranRinci.Kd_SubRinci',
                'Ta_AnggaranRinci.No_Urut',
                'Ta_AnggaranRinci.Uraian',
                'Ta_AnggaranRinci.SumberDana',
                'Ta_AnggaranRinci.JmlSatuanPAK',
                'Ta_AnggaranRinci.Satuan',
                'Ta_AnggaranRinci.HrgSatuanPAK',
                'Ta_AnggaranRinci.AnggaranStlhPAK'
            )
            ->where('Ta_AnggaranRinci.KdPosting', $maxKdPosting)
            ->orderBy('Ta_AnggaranRinci.Kd_Rincian')
            ->orderBy('Ta_AnggaranRinci.Kd_SubRinci')
            ->orderBy('Ta_AnggaranRinci.No_Urut')
            ->chunk(500, function ($rincianList) {
                foreach ($rincianList as $rincian) {
                    $paket = PaketPekerjaan::where('kd_keg', $rincian->Kd_Keg)
                        ->where('tahun', $rincian->Tahun)
                        ->where('kd_desa', $rincian->Kd_Desa)
                        ->first();

                    if (!$paket) {
                        continue;
                    }

                    $existing = PaketPekerjaanRinci::where('paket_pekerjaan_id', $paket->id)
                        ->where('kd_rincian', $rincian->Kd_Rincian)
                        ->where('kd_subrinci', $rincian->Kd_SubRinci)
                        ->where('no_urut', $rincian->No_Urut)
                        ->first();

                    if ($existing && $existing->use_st) {
                        continue;
                    }

                    $data = [
                        'paket_pekerjaan_id' => $paket->id,
                        'kd_posting' => $rincian->KdPosting,
                        'tahun' => $rincian->Tahun,
                        'kd_desa' => $rincian->Kd_Desa,
                        'kd_keg' => $rincian->Kd_Keg,
                        'kd_rincian' => $rincian->Kd_Rincian,
                        'nama_obyek' => $rincian->nama_obyek,
                        'kd_subrinci' => $rincian->Kd_SubRinci,
                        'no_urut' => $rincian->No_Urut,
                        'uraian' => $rincian->Uraian,
                        'sumber_dana' => $rincian->SumberDana,
                        'jml_satuan_pak' => $rincian->JmlSatuanPAK,
                        'satuan' => $rincian->Satuan,
                        'hrg_satuan_pak' => $rincian->HrgSatuanPAK,
                        'anggaran_stlh_pak' => $rincian->AnggaranStlhPAK,
                    ];

                    if ($existing) {
                        $existing->update($data);
                    } else {
                        $data['use_st'] = false;
                        PaketPekerjaanRinci::create($data);
                    }
                }
            });

        $this->info("✅ Sinkronisasi selesai. (KdPosting: $maxKdPosting)");
    }
}
