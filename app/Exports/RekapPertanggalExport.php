<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\Pemeriksaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPertanggalExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     *
     *
     */

    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $data = Pemeriksaan::where('created_at', '>=', $this->request->date_start);
        return view();
    }
}
