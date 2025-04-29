<?php

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHasilPemeriksaan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'laporan_hasil_pemeriksaan';
}
