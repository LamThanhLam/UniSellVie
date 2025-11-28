<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
    ];

    // An Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An Order has many OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
