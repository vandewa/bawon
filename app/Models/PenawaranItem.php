<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function rincian()
    {
        return $this->belongsTo(PaketKegiatanRinci::class, 'paket_kegiatan_rinci_id');
    }
}
