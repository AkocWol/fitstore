<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // <-- deze regel is essentieel!

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'image',
    ];
}
