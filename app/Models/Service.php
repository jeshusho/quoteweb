<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    
    protected $with = ['group'];

    protected $fillable = [
        //'group_id',
        'code',
        'description',
        'repo',
        'measure',
        'have_igv',
        'unit_price',
        'unit_igv',
        'unit_value',
        'unit_price2',
        'unit_igv2',
        'unit_value2',
        'have_measures',
        'have_parts',
        'is_qty',
        'status',
    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class,'service_part','service_id','part_id')->withPivot(['part_qty', 'measure']);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
