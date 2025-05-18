<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function status()
    {
        return $this->belongsTo(ComCode::class, 'status_berita_st', 'com_cd');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
