<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Uttp;

class GlobalExport implements FromView
{
    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $monthlyData = [];

        // Loop through each month to get the data
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = Uttp::withCount([
                'pengajuan' => function ($query) use ($month) {
                    $query->whereHas('pengajuannya', function ($query) {
                        $query->where('pengajuan_st', 'PENGAJUAN_ST_05');
                    });
                    // Get the data for the specified year and month
                    $query->whereYear('created_at', $this->request->tahun)
                        ->whereMonth('created_at', $month);
                }
            ])->get();
        }

        // Calculate total counts for each month and overall total
        $monthlyCounts = [];
        $totalPengajuanCount = 0;

        foreach ($monthlyData as $month => $data) {
            $monthlyCounts[$month] = $data->sum('pengajuan_count');
            $totalPengajuanCount += $monthlyCounts[$month];
        }

        // Pass the data to the view
        return view('laporan.global', compact('monthlyData', 'monthlyCounts', 'totalPengajuanCount'));
    }
}
