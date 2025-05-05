<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'attendee_limit',
        'reservation_deadline',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function canBeReserved(): bool
    {
        return now()->lt($this->reservation_deadline) &&
            $this->reservations()->count() < $this->attendee_limit;
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0.0;
    }
}
