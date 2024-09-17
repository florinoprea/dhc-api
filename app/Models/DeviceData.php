<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceData extends Model
{
    use HasFactory;

    protected $table = 'device_data';


    protected $fillable = [
        'device',
        'data'
    ];

    protected $casts = [
    ];

    protected static function boot()
    {
        parent::boot();
    }
}
