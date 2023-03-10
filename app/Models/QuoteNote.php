<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteNote extends Model
{
    use HasFactory;
    //protected $table = 'quote_note';
    public $timestamps = false;

    protected $fillable = [
        'quote_id',
        'description',
        'editable',
    ];
}
