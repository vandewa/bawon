<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegosiasiLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function negosiasi()
    {
        return $this->belongsTo(Negoisasi::class, 'negoisasi_id');
    }

    public function items()
    {
        return $this->hasMany(NegosiasiLogItem::class, 'negosiasi_log_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
