<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteService extends Model
{
    use HasFactory;
    protected $table = 'quote_service';
    public $timestamps = false;

    protected $fillable = [
        'quote_id',
        'service_id',
        'code',
        'group_name',
        'description',
        'measure',
        'quantity',
        'unit_price',
        'unit_original_price',
        'subtotal',
        'igv',
        'total',
        'have_measures',
        'have_parts',
        'is_qty',
    ];
}
