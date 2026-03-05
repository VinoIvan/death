<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'type', 
        'value', 
        'phone_1',
        'phone_2',
        'work_days_week',
        'work_days_weekend',
        'work_hours_week',
        'work_hours_weekend',
        'icon', 
        'is_active', 
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}