<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Uttp;

class TriwulanExport implements FromView
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
        $data = Uttp::withCount([
            'pengajuan' => function ($a)  {
                $a->whereHas('pengajuannya', function ($a) {
                    $a->where('pengajuan_st', 'PENGAJUAN_ST_05');
                });
                $a->whereBetween('created_at', [$this->request->start_date, $this->request->end_date . ' 23:59:59']);
            }
        ])->get();

        $totalPengajuanCount = $data->sum('pengajuan_count');
        return view('laporan.rekap-pertanggal', compact('data', 'totalPengajuanCount'));
    }
}
