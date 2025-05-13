<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketKegiatanRinci extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paketKegiatan()
    {
        return $this->belongsTo(PaketKegiatan::class);
    }
    public function rincian()
    {
        return $this->belongsTo(PaketPekerjaanRinci::class, 'paket_pekerjaan_rinci_id');
    }

}
