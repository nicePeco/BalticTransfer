<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'sender_id',
        'message',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function offer()
    {
        return $this->belongsTo(offers::class, 'offer_id');
    }
}
