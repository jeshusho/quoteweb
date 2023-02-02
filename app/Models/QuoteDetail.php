<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'quote_id',
        'service_id',
        'part_id',
        'part_qty',
        'quantity',
        'measure',
        'description',
    ];
}
