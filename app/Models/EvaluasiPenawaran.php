<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiPenawaran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }

}
