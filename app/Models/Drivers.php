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
        //12.3
        'car_photo',
        'car_make', 
        'car_model', 
        'car_year',
        'rating',
        'rating_count',
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

}
