<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id', 'scheduled_for', 'description', 'status'];
}