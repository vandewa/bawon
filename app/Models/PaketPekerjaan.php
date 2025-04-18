<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPekerjaan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function desa()
{
    return $this->belongsTo(\App\Models\Desa::class, 'desa_id');
}
}
