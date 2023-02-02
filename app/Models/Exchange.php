<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'date',
        'currency',
        'real_buy',
        'real_sell',
        'sell',
        'exchange_rate',
    ];
}
