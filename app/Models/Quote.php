<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $with = ['services','parts','notes','details'];

    protected $fillable = [
        'external_id',
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
        'payday',
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

    public function services()
    {
        return $this->hasMany(QuoteService::class);
    }

    public function parts()
    {
        return $this->hasMany(QuotePart::class);
    }

    public function notes()
    {
        return $this->hasMany(QuoteNote::class);
    }

    public function details()
    {
        return $this->hasMany(QuoteDetail::class);
    }
}
