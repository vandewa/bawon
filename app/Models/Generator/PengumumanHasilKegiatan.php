<?php

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanHasilKegiatan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'pengumuman_hasil_kegiatan';
}
