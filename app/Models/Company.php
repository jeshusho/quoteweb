<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'name',
        'comercial_name',
        'slogan',
        'address',
        'departament',
        'province',
        'district',
        'estatus',
        'condition',
        'location',
        'zip_code'
    ];
}
