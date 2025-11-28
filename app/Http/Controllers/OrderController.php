<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import for error logging

class OrderController extends Controller
{
    // Process the checkout
    public function checkout(Request $request)
    {
        $userId = Auth::id();
        // Load cart items along with product information to calculate total
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add products before checking out.');
        }

        // Calculate total amount 
        $totalAmount = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Use a transaction for atomic operation (all or nothing)
        DB::beginTransaction();

        try {
            // 1. Create the Order header
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'status' => 'Paid', // Mocking immediate payment
                'payment_method' => 'Online Payment',
            ]);

            // 2. Move cart items to order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price, // Store the price at the time of purchase
                    'quantity' => $item->quantity,
                ]);
            }

            // 3. Clear the Cart
            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            // Redirect to the specific order confirmation page
            return redirect()->route('orders.show', $order->id)->with('success', 'Your order has been placed successfully! Thank you for your purchase.');

        } catch (\Exception $e) {
            DB::rollback();
            // Log the error for better debugging
            Log::error('Order checkout failed for user ' . $userId . ': ' . $e->getMessage());

            return redirect()->route('cart.index')->with('error', 'An error occurred during checkout. Please try again.');
        }
    }

    // Display the user's order history
    public function index()
    {
        $orders = Auth::user()->orders()
                      ->with('items.product') // Eager load relations for display
                      ->latest()
                      ->get();

        return view('orders.index', compact('orders'));
    }

    // Display a specific order details
    public function show(Order $order)
    {
        // Security check: ensure the user views their own order
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('orders.index')->with('error', 'You do not have permission to view this order.');
        }

        $order->load('items.product'); // Load details if not already loaded

        return view('orders.show', compact('order'));
    }
}
