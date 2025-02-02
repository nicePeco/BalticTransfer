<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'photo_path'];

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'driver_id');
    }
}
