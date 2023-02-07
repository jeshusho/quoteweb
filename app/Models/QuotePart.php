<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotePart extends Model
{
    use HasFactory;
    protected $table = 'quote_part';
    public $timestamps = false;

    protected $fillable = [
        'quote_id',
        'part_id',
        'description',
        'measure',
        'measure_code_ref',
        'quantity',
        'unit_price',
        'subtotal',
        'igv',
        'total'
    ];
}
