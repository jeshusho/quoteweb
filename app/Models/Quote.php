<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'date',
        'user_id',
        'customer_id',
        //'contact_id',
        'document_type',
        'document_number',
        'name',
        'address',
        'phone',
        'email',
        'contact',
        'brand',
        'motor',
        'factor1',
        'factor2',
        'factor3',
        'factor4',
        'reference',
        'currency',
        'subtotal',
        'igv',
        'total',
        'technician_id',
        'scheduled_date',
        'scheduled_minutes',
        'executed_date',
        'executed_minutes',
        'observations',
        'status',
        'is_paid',
    ];
}
