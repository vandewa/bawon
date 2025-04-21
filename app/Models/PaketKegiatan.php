<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketKegiatan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paketPekerjaan()
    {
        return $this->belongsTo(PaketPekerjaan::class);
    }

    public function paketType() {
        return $this->belongsTo(ComCode::class, 'paket_type', 'com_cd');
    }
    public function paketKegiatan() {
        return $this->belongsTo(ComCode::class, 'paket_kegiatan', 'com_cd');
    }
}
