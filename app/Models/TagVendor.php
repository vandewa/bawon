<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagVendor extends Model
{
    use HasFactory;

    protected $table = 'tag_vendor';
    public $guarded = [];
}
