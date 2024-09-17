<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientBloodGlucose extends Model
{
    use HasFactory;

    protected $table = 'patient_blood_glucose';


    protected $fillable = [
        'patient_id',
        'glucose'
    ];

    protected $casts = [
        'glucose' => 'integer',
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
