<?php

namespace App\Models;

use App\Http\Controllers\DriversController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Drivers extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'car_photo',
        'car_make', 
        'car_model', 
        'car_year',
        'rating',
        'rating_count',
        'total_company_share',
        'suspended_until',
        'license_plate',
        'license_front',
        'license_back',
        'verification_status',
        'admin_notes',
        'license_plate',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class, 'driver_id');
    }

    public function getFormattedRatingAttribute()
    {
        return $this->rating ? number_format($this->rating, 1) : 'Not Rated';
    }

    public function carPhotos()
    {
        return $this->hasMany(CarPhoto::class, 'driver_id');
    }

}
