<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAdd extends Model
{
    use HasFactory;

    protected $fillable = [
        'productname',
        'cat',
        'subcat',
        'description',
        'price',
        'images',
    ];
}
