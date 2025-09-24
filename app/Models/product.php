<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Implement fields that can be assigned with multiple values (mass assignable)
    protected $fillable = [
        'title',
        'releaseDate',
        'developer',
        'publisher',
        'description',
        'platform',
        'genre',
        'content',
        'price',
        'image'
    ];

    // Automatically convert 'releaseDate' into Carbon object (date & month)
    protected $casts = [
        'releaseDate' => 'date',
    ];
}