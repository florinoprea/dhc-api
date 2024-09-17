<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'is_admin',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'active' => 'boolean',
    ];

    protected $dates = ['dob'];

    public function scopePatient($query)
    {
        return $query->where('is_admin', 0);
    }

    public function weight()
    {
        return $this->hasMany(PatientWeight::class, 'patient_id');
    }

    public function last_weight()
    {
        return $this->hasOne(PatientWeight::class, 'patient_id')->latest();
    }



    public function blood_pressure()
    {
        return $this->hasMany(PatientBloodPressure::class, 'patient_id');
    }

    public function last_blood_pressure()
    {
        return $this->hasOne(PatientBloodPressure::class, 'patient_id')->latest();
    }

    public function blood_glucose()
    {
        return $this->hasMany(PatientBloodGlucose::class, 'patient_id');
    }

    public function last_blood_glucose()
    {
        return $this->hasOne(PatientBloodGlucose::class, 'patient_id')->latest();
    }


    public function blood_oxygen()
    {
        return $this->hasMany(PatientBloodOxygen::class, 'patient_id');
    }

    public function last_blood_oxygen()
    {
        return $this->hasOne(PatientBloodOxygen::class, 'patient_id')->latest();
    }

    public function monitoring()
    {
        return $this->belongsToMany(MonitoringCategory::class, 'patient_monitoring_categories', 'patient_id', 'monitoring_category_id');
    }

    public function name(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                return collect([
                    $attributes['first_name'],
                    $attributes['last_name']
                ])->reject(function ($item) {
                    return trim($item) == '' || is_null($item);
                })->implode(' ');
            }
        );
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token): void
    {
        $url = env('APP_URL', 'https://app.dhcremote.com') . env('APP_BASE_URL', '/') . 'auth/'. ($this->is_admin ? 'password-change' : 'patients-password-change')  .'?token='.$token;

        $this->notify(new ResetPasswordNotification($url));
    }
}
