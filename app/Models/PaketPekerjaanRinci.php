<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPekerjaanRinci extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kegiatanRinci()
    {
        return $this->hasMany(PaketKegiatanRinci::class, 'paket_pekerjaan_rinci_id');
    }


}
