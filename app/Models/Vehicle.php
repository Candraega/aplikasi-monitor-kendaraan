<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'license_plate',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class)->latest();
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class)->latest();
    }

}