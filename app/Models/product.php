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
        'system_requirements',
        'content',
        'price',
        'image'
    ];

    // Adding relationships
    public function platforms()
    {
        // Scpecify the name of the relational table is 'product_platform'
        return $this->belongsToMany(Platform::class, 'product_platform');
    }

    public function genres()
    {
        // Scpecify the name of the relational table is 'product_genre'
        return $this->belongsToMany(Genre::class, 'product_genre');
    }

    // Automatically convert 'releaseDate' into Carbon object (date & month)
    protected $casts = [
        'releaseDate' => 'date',
    ];
}