<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'productname',
        'cat',
        'subcat',
        'description',
        'price',
        'images', // Just the field name here
    ];

    protected $casts = [
        'images' => 'array', // Casting to array here
    ];
}
