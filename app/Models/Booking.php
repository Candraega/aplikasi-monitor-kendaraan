<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; 
use Spatie\Activitylog\LogOptions;          

class Booking extends Model
{
    use HasFactory;
    use HasFactory, LogsActivity; 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() 
            ->setDescriptionForEvent(fn(string $eventName) => "Data pemesanan telah {$eventName}");
    }

    protected $fillable = [
        'admin_id',
        'vehicle_id',
        'driver_id',
        'purpose',
        'start_date',
        'end_date',
        'status'
    ];


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvals()
    {
        return $this->hasMany(BookingApproval::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}