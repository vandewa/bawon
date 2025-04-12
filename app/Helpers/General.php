<?php

use App\Models\Pengajuan;
use Illuminate\Support\Facades\DB;

function genNo()
{
    $a = Pengajuan::select(DB::raw(
        "
        concat(" . date('Y') . ",'-', LPAD(CAST(right(order_no,4) as UNSIGNED) +1 , 4, '0')) as no
        "
    ))->whereRaw("left(order_no,4) = ?", [date('Y')])->orderBy(DB::raw("CAST(right(order_no,4) as UNSIGNED)"), 'desc')->first();
    if ($a) {
        return $a->no;
    }

    return date('Y') . "-0001";
}

if (!function_exists('konversi_nomor')) {
    function konversi_nomor($nohp)
    {
        // kadang ada penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // kadang ada penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // kadang ada penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 3) == '+62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '+62' . substr(trim($nohp), 1);
            }
            return $hp ?? '';
        }
    }
}
