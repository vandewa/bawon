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
    public function statusKegiatan()
    {
        return $this->belongsTo(ComCode::class, 'paket_kegiatan', 'com_cd');
    }
        public function penawarans()
    {
        return $this->hasMany(Penawaran::class);
    }

    public function penawaranTerpilih()
    {
        return $this->hasOne(Penawaran::class)->where('penawaran_st', 'PENAWARAN_ST_02'); // atau pakai where kondisi tertentu jika diperlukan
    }

    public function negosiasi() {
        return $this->hasOne(Negoisasi::class);
    }

    public function rincian()
    {
        return $this->hasMany(PaketKegiatanRinci::class);
    }


}
