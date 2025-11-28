<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price', // Essential for historical record
        'quantity',
    ];

    // An OrderItem belongs to an Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // An OrderItem belongs to a Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
