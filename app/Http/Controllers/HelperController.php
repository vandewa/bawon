<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    public function showPicture(Request $request)
    {

    $path = $request->get('path');

    // Cegah akses file tanpa path
    if (!$path) {
        abort(404, 'Path tidak diberikan.');
    }

    // Amankan path agar tidak keluar dari direktori storage
    if (str_contains($path, '..')) {
        abort(403, 'Akses tidak sah.');
    }

    // Cek apakah file ada di disk default (bisa juga ditentukan 'public'/'local' jika perlu)
    if (Storage::exists($path)) {
        return Storage::response($path);
    }

    // File tidak ditemukan
    return response("File tidak ditemukan", 404);
    }
}
