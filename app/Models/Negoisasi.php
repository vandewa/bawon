<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negoisasi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(ComCode::class, 'negosiasi_st', 'com_cd');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
