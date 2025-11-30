<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Add product to cart
    public function store(Request $request, Product $product)
    {
        // CHECK OWNERSHIP: Prevent re-purchase if the game is in the user's library
        $isOwned = OrderItem::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->exists();

        if ($isOwned) {
            return redirect()->back()->with('error', 'You have already owned this game! Check your Library.');
        }

        // CHECK IF ALREADY IN CART (Only one copy of a game is allowed in the cart)
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            // For a game store, we prevent adding the same item multiple times
            return redirect()->route('cart.index')->with('warning', 'This game is already in your cart.');
        } else {
            // Create a new cart item
            
            // Get price directly from Product model (safer than relying on external request data)
            $productPrice = $product->price;

            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'price' => $productPrice,
                'quantity' => 1,
            ]);
            return redirect()->route('cart.index')->with('success', 'Added ' . $product->title . ' to your cart!');
        }
    }
    
    // 2. Display the Cart
    public function index()
    {
        $cartItems = CartItem::with('product') // Eager load product details
                              ->where('user_id', Auth::id())
                              ->get();
                              
        $totalPrice = $cartItems->sum(function($item) {
            // Calculate total price based on product price and quantity (default 1)
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    // 3. Remove an item from the cart
    public function destroy(CartItem $cartItem)
    {
        // Security check: ensure the user only deletes their own items
        if ($cartItem->user_id !== Auth::id()) {
            return redirect()->route('cart.index')->with('error', 'You do not have permission to remove this item.');
        }
        
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
}
