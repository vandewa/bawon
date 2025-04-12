<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class SidangTeraExport implements FromView
{

    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $uttpNames = DB::table('uttps')
                        ->select('nama')
                        ->distinct()
                        ->orderBy('nama', 'asc')
                        ->pluck('nama')
                        ->toArray();

        // Buat kolom-kolom dinamis berdasarkan nama UTTP
        $columns = [];
        foreach ($uttpNames as $name) {
            $columns[] = "MAX(CASE WHEN u.nama = '$name' THEN psu.jumlah ELSE 0 END) AS `$name`";
        }
        $columnList = implode(', ', $columns);

        // Bangun query dinamis untuk crosstab
        $query = "
            SELECT jt.id, ps.nama AS peserta, $columnList
            FROM jadwal_teras jt
            JOIN peserta_sidangs ps ON jt.id = ps.jadwal_tera_id
            JOIN peserta_sidang_uttps psu ON psu.peserta_sidang_id = ps.id
            JOIN uttps u ON u.id = psu.uttp_id
            where jt.id = ".$this->request->id."
            GROUP BY jt.id, ps.nama
            ORDER BY jt.id, ps.nama;
        ";
// dd($query);
            // Eksekusi query menggunakan raw SQL
            $results = DB::select($query);

// Kirim hasil dan nama-nama kolom ke view untuk ditampilkan
        return view('laporan.rekap-sidang', compact('results', 'uttpNames'));
    }
}
