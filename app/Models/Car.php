<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'brand',
        'model',
        'year',
        'motor',
        'motor_number',
        'plate',
    ];,