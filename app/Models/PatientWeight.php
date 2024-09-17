<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientWeight extends Model
{
    use HasFactory;

    protected $table = 'patient_weight';


    protected $fillable = [
        'patient_id',
        'weight'
    ];

    protected $casts = [
        'active' => 'double',
    ];

    protected static function boot()
    {
        parent::boot();
    }


    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

}
