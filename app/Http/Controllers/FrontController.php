<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Regulasi;
use App\Models\Vendor;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    public function beranda()
    {
        $berita = Berita::where('status_berita_st', 'STATUS_BERITA_ST_01')->orderBy('created_at', 'desc')->limit(6)->get();

        return view('layouts.beranda', [
            'berita' => $berita
        ]);
    }

    public function regulasi(Request $request)
    {

        if ($request->ajax()) {
            $data = Regulasi::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="#" class="btn btn-sm btn-warning">Edit</a>';
                    $deleteBtn = '<a href="#" class="btn btn-sm btn-danger">Hapus</a>';
                    return "<div class='btn-group'>$editBtn $deleteBtn</div>";
                })
                ->addColumn('dokumen', function ($row) {
                    if ($row->file_path) {
                        return '<a href="' . Storage::url($row->file_path) . '" target="_blank" class="btn btn-sm btn-info">Lihat</a>';
                    }
                    return '<span class="text-muted">Tidak ada dokumen</span>';
                })
                ->rawColumns(['action', 'dokumen'])
                ->make(true);
        }

        return view('layouts.regulasi');
    }
    public function daftarPenyedia(Request $request)
    {

        if ($request->ajax()) {
            $data = Vendor::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('layouts.daftar-penyedia');
    }


}