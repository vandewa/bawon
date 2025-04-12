<?php

namespace App\Http\Controllers;

use App\Exports\GlobalExport;
use App\Models\Uttp;
use Illuminate\Http\Request;
use App\Exports\RekapPertanggalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SidangTeraExport;
use Illuminate\Support\Facades\DB;
use App\Exports\TriwulanExport;

class LaporanController extends Controller
{
    public function rekap()
    {
        return view('rekap');
    }

    public function storeTriwulan(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);



        return Excel::download(new SidangTeraExport($request), 'laporan-triwulan.xlsx');

    }

    public function storeGlobal(Request $request)
    {
        // Initialize an array to store the results per month
        return Excel::download(new GlobalExport($request), 'laporan-global.xlsx');

    }

    public function rekapSidang(Request $request) {
        // Ambil semua nama UTTP yang ada di tabel uttps
        return Excel::download(new SidangTeraExport($request), 'rekap-sidang.xlsx');

    }

    // public function rekapPertanggal(Request $request)
    // {
    //     $data = Uttp::where('created_at', '>=', $request->start_date)->get();

    //     return view('laporan.rekap-pertanggal', compact('data'));

    //     // return Excel::download(new RekapPertanggalExport($request), 'namafiledownload.xlsx');

    // }
}
