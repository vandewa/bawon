<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Desa;

class SyncDesaFromMssql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:desa-mssql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menyalin data Ref_Desa dari MSSQL ke MySQL tabel desas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mengambil data dari MSSQL...');

        $refDesaList = DB::connection('sqlsrv')
            ->table('Ref_Desa')
            ->select('Kd_Kec', 'Kd_Desa', 'Nama_Desa')
            ->get();

        $this->info("Jumlah data diambil: {$refDesaList->count()}");

        $insertData = [];

        foreach ($refDesaList as $ref) {
            $insertData[] = [
                'kabupaten' => 'Wonosobo',
                'kode_desa' => $ref->Kd_Desa,
                'kecamatan_id' => $ref->Kd_Kec,
                'name' => $ref->Nama_Desa,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Desa::upsert(
            $insertData,
            ['kode_desa'], // Unique by
            ['kabupaten', 'kecamatan_id', 'name', 'updated_at'] // Fields to update
        );

        $this->info('Sinkronisasi selesai tanpa duplikat.');
    }
}
