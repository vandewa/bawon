<?php

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenggunaanSumberDaya extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'laporan_penggunaan_sumber_daya';
}
