<?php

namespace App\Models\Generator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPembahasan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'hasil_pembahasan';
}
