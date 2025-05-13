<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_vendor');
    }
    public function jenisUsaha()
    {
        return $this->belongsTo(ComCode::class, 'jenis_usaha');
    }
    public function photos()
    {
        return $this->hasMany(VendorPhoto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
