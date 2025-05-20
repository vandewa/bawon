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
    $this->info('🚀 Mulai sinkronisasi data rincian unik terbaru...');

    $limit = 500;
    $offset = 25000;
    $chunkCount = 0;
    $totalInserted = 0;
    $connection = DB::connection('sqlsrv');
    $connection->setQueryGrammar(new \Illuminate\Database\Query\Grammars\SqlServerGrammar);
    $connection->getPdo()->setAttribute(\PDO::ATTR_TIMEOUT, 120); // 60 detik timeout
    do {
        $results = DB::connection('sqlsrv')->select("
            WITH Ranked AS (
    SELECT
        a.KdPosting,
        a.Tahun,
        a.Kd_Desa,
        a.Kd_Keg,
        a.Kd_Rincian,
        rr.Nama_Obyek,
        a.Kd_SubRinci,
        a.No_Urut,
        a.Uraian,
        a.SumberDana,
        a.JmlSatuanPAK,
        a.Satuan,
        a.HrgSatuanPAK,
        a.AnggaranStlhPAK,
        ROW_NUMBER() OVER (
            PARTITION BY
                a.Tahun,
                a.Kd_Desa,
                a.Kd_Keg,
                a.Kd_Rincian,
                a.Kd_SubRinci,
                a.No_Urut
            ORDER BY a.KdPosting DESC
        ) AS rn
    FROM Ta_Kegiatan tk
    JOIN Ta_KegiatanOutput tko  ON tk.Kd_Keg = tko.Kd_Keg
    JOIN Ta_Anggaran ta          ON ta.Kd_Keg = tko.Kd_Keg
    JOIN Ref_Rek4 rr             ON rr.Obyek = ta.Kd_Rincian
    JOIN Ta_AnggaranRinci a      ON a.Kd_Keg = ta.Kd_Keg AND ta.Kd_Rincian = a.Kd_Rincian
)
SELECT *
FROM Ranked
WHERE rn = 1
  AND AnggaranStlhPAK > 0
ORDER BY Kd_Keg, Kd_Rincian
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
        ", [$offset, $limit]);

        $processedInChunk = 0;

        foreach ($results as $rincian) {
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
                'nama_obyek' => $rincian->Nama_Obyek,
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
                $processedInChunk++;
            }
        }

        $totalInserted += $processedInChunk;
        $chunkCount++;
        $this->info("📦 Chunk {$chunkCount} diproses. Tambahan data baru: {$processedInChunk}");

        $offset += $limit;
    } while (count($results) > 0);

    $this->info("✅ Sinkronisasi selesai. Total data baru disalin: {$totalInserted}, total chunk: {$chunkCount}");
}

}
