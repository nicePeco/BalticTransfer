<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Client;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class offers extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'location_one', //location one
        'city_one', //location two
        'location_two', //passenger count 
        'city_two', // date and time
        'information', //info
        'distance',
        'time',
        'offers_id',
        'accepted_driver_id',
    ];

    public function getRouteKey()
    {
        $hashids = new Hashids(env('APP_KEY'), 10); // 10-character hash
        return $hashids->encode($this->id);
    }

    public function getHashedIdAttribute()
    {
        $hashids = new Hashids(env('APP_KEY'), 10); // 10-character hash
        return $hashids->encode($this->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'offers_id');
    }

    public function rides()
    {
        return $this->hasMany(Ride::class, 'offer_id');
    }

    public function acceptedDriver()
    {
        return $this->belongsTo(Drivers::class, 'accepted_driver_id');
    }
    
    public function client()
    {
        return $this->belongsTo(User::class, 'offers_id');
    }
}
