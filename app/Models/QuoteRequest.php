<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'location',
        'product',
        'quantity',
        'emailed',
    ];
}
