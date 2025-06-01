<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Mendapatkan semua data TPK (Tim Pelaksana Kegiatan) yang terkait dengan Tim ini.
     * Relasi satu-ke-banyak (satu Tim bisa memiliki banyak TPK).
     *
     * Asumsi: Tabel 'tpks' memiliki kolom 'tim_id' sebagai foreign key.
     */
    public function tpks()
    {
        return $this->hasMany(Tpk::class, 'tim_id');
    }

    // Anda mungkin juga ingin menambahkan relasi ke Desa jika diperlukan,
    // karena tabel 'tims' memiliki 'desa_id'
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

     public function ketua()
    {
        return $this->belongsToMany(Aparatur::class, 'tpks', 'tim_id', 'aparatur_id')
                    // PERUBAHAN: Filter pivot table berdasarkan tpk_type
                    ->wherePivot('tpk_type', 'TPK_TYPE_01');
    }


}
