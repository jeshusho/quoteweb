<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'measure',
        'unit_price',
        'unit_igv',
        'unit_value',
        'status',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class,'service_part','part_id','service_id')->withPivot(['part_qty', 'measure','inherit_measure']);
    }
}
