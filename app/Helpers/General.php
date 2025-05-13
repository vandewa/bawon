<?php

use App\Models\Penawaran;
use App\Models\Pengajuan;
use App\Models\User;
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

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = [
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh ',
            'sebelas '
        ];
        $hasil = '';

        if ($angka < 12) {
            $hasil = ' ' . $baca[$angka];
        } elseif ($angka < 20) {
            $hasil = terbilang($angka - 10) . ' belas ';
        } elseif ($angka < 100) {
            $hasil = terbilang($angka / 10) . ' puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = ' seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = terbilang($angka / 100) . ' ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = ' seribu' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = terbilang($angka / 1000) . ' ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = terbilang($angka / 1000000) . ' juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = terbilang($angka / 1000000000) . ' miliar ' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $hasil = terbilang($angka / 1000000000000) . ' triliun ' . terbilang($angka % 1000000000000);
        }

        return trim($hasil);
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka, $withPrefix = true)
    {
        $formatted = number_format($angka, 0, ',', '.');
        return $withPrefix ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('formatTanggalIndonesia')) {

    function formatTanggalIndonesia($tanggal = null)
    {
        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $tanggal = $tanggal ?? date('Y-m-d');
        $tanggalObj = date_create($tanggal);
        $tgl = date_format($tanggalObj, 'j');
        $bln = (int) date_format($tanggalObj, 'n');
        $thn = date_format($tanggalObj, 'Y');

        return "{$tgl} {$bulan[$bln]} {$thn}";
    }
}


if (!function_exists('badgePenawaran')) {
    function badgePenawaran()
    {
        return Penawaran::with(['paketKegiatan'])
            ->whereHas('paketKegiatan', function ($query) {
                $query->where('paket_type', 'PAKET_TYPE_01');
            })
            ->where('bukti_setor_pajak', null)
            ->orWhere('dok_penawaran', null)
            ->orWhere('dok_kebenaran_usaha', null)
            ->where('vendor_id', auth()->user()->vendor_id)
            ->count();
    }

}
if (!function_exists('ambilUserIdVendor')) {
    function ambilUserIdVendor($id)
    {
        return User::where('vendor_id', $id)->first()->id;
    }
}



