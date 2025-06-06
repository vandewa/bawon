<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paketPekerjaans()
    {
        return $this->hasMany(PaketPekerjaan::class, 'desa_id');
    }
    public function user() {
        return $this->hasOne(User::class, 'desa_id');
    }

    // Accessor untuk nama desa selalu format ucwords
    public function getNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

      public function kepalaDesa()
    {
        return $this->hasOne(Aparatur::class, 'desa_id')->where('jabatan', 'Kepala Desa');
    }
}
