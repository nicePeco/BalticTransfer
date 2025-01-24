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
        return $this->belongsTo(Drivers::class, 'driver_id');
    }

    protected static function booted()
    {
        static::created(function ($payment) {
            // Update the total company share for the driver
            $driver = Drivers::find($payment->driver_id);
            if ($driver) {
                $driver->total_company_share = Payment::where('driver_id', $driver->id)->sum('company_share');
                $driver->save();
            }
        });

        static::updated(function ($payment) {
            // Update the total company share for the driver
            $driver = Drivers::find($payment->driver_id);
            if ($driver) {
                $driver->total_company_share = Payment::where('driver_id', $driver->id)->sum('company_share');
                $driver->save();
            }
        });

        static::deleted(function ($payment) {
            // Update the total company share for the driver when a payment is deleted
            $driver = Drivers::find($payment->driver_id);
            if ($driver) {
                $driver->total_company_share = Payment::where('driver_id', $driver->id)->sum('company_share');
                $driver->save();
            }
        });
    }  
}
