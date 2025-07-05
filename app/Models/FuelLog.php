<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelLog extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id', 'user_id', 'date', 'liters', 'cost', 'odometer'];
}