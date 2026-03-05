<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'date', 'start_time', 'end_time', 'service_id', 
        'max_bookings', 'current_bookings', 'is_available', 'created_by'
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
        'max_bookings' => 'integer',
        'current_bookings' => 'integer'
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isFullyBooked(): bool
    {
        return $this->current_bookings >= $this->max_bookings;
    }

    public function hasAvailableSeats(): bool
    {
        return $this->is_available && !$this->isFullyBooked();
    }
}