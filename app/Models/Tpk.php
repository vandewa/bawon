<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpk extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function aparatur()
    {
        return $this->belongsTo(Aparatur::class);
    }

    public function jenis()
    {
        return $this->belongsTo(ComCode::class, 'tpk_type');
    }

    public function tim()
    {
        return $this->belongsTo(ComCode::class, 'tim_type');
    }


}
