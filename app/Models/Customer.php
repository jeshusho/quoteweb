<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_id',
        'code',
        'document_type',
        'document_number',
        'name',
        'comercial_name',
        'address',
        'departament',
        'province',
        'district',
        'estatus',
        'condition',
        'location',
        'phone',
        'email',
        'payday',
        'currency',
        'factor2',
        'contact',
        'payment_day',
        'payment_phone',
        'payment_contact',
        'status',
    ];
}
