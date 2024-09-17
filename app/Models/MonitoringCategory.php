<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringCategory extends Model
{
    use HasFactory;

    protected $table = 'monitoring_categories';


    protected $fillable = [
        'slug',
        'name',
        'device',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
    }



    public function scopeActive($query)
    {
        return $query->where('active', '=', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', '=', 0);
    }

    public function patients()
    {
        return $this->belongsToMany(User::class, 'patient_monitoring_categories', 'monitoring_category_id', 'patient_id');
    }

}
