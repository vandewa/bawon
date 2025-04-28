<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function evaluasi()
    {
        return $this->hasOne(EvaluasiPenawaran::class);  // Pastikan relasi benar
    }
    public function paketKegiatan()
    {
        return $this->belongsTo(PaketKegiatan::class);
    }
}
