<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'schedule_id', 'status_id',
        'client_name', 'client_phone', 'client_email', 'comment', 'booking_code'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($appointment) {
            if (empty($appointment->booking_code)) {
                $appointment->booking_code = Str::random(32);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(AppointmentStatus::class, 'status_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function visitHistory()
    {
        return $this->hasOne(VisitHistory::class);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('status', fn($q) => $q->where('name', $status));
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status->name) {
            'ожидание' => 'warning',
            'принято' => 'success',
            'в обработке' => 'info',
            'отменено' => 'danger',
            'завершено' => 'secondary',
            default => 'secondary'
        };
    }
}