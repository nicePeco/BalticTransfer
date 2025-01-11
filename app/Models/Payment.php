<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'driver_id',
        'total_earnings',
        'company_share',
        'week_start',
        'week_end',
    ];

    public function driver()
    {
        return $this->belongsTo(Drivers::class);
    }
}
