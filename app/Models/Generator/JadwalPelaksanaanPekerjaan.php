<?php

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelaksanaanPekerjaan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'jadwal_pelaksanaan_pekerjaan';
}
