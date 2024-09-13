<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
        'quantity',
        'price',
    ];
}
