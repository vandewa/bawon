<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegosiasiLogItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function log()
    {
        return $this->belongsTo(NegosiasiLog::class, 'negosiasi_log_id');
    }

    public function rincian()
    {
        return $this->belongsTo(PaketKegiatanRinci::class, 'paket_kegiatan_rinci_id');
    }
}
