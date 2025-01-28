<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User;
use App\Notifications\DriverAppliedNotification;
use Hashids\Hashids;

class Ride extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['driver_id', 'offer_id', 'price'];

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'driver_id');
    }

    public function offer()
    {
        return $this->belongsTo(offers::class, 'offer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'offers_id');
    }

    public function getHashedIdAttribute()
    {
        $hashids = new Hashids(env('APP_KEY'), 10); // 10-character hash
        return $hashids->encode($this->id);
    }
}
