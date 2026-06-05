<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'agency_id',
        'make',
        'model',
        'year',
        'category',
        'description',
        'price_per_day',
        'price_per_week',
        'options',
        'cancellation_policy',
        'is_available',
    ];

    protected $casts = [
        'options' => 'array',
        'is_available' => 'boolean',
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    public function unavailabilities()
    {
        return $this->hasMany(VehicleUnavailability::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Booking::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(VehiclePhoto::class)->where('is_primary', true);
    }
}
