<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Adding relationships
    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    
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

    // Automatically convert 'releaseDate' into Carbon object (date & month)
    protected $casts = [
        'releaseDate' => 'date',
    ];
}