<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComCode extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'com_cd';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function paketTypes()
    {
        return self::where('code_group', 'PAKET_TYPE')->pluck('code_nm', 'com_cd');
    }
}
