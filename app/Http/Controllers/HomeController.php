<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Get list of products (like in management page, but not admin filter)
        $query = Product::query();

        // Search-logic (If there is a search form on homepage)
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }
        
        // 2. Get result (Load relationship platforms & genres)
        $products = $query->with('platforms', 'genres')->paginate(10);

        // 3. Transmit $products to home.blade.php
        return view('home', compact('products'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Get product detail, load essential relationships
        $product->load('platforms', 'genres');

        $isOwned = false;

        // Only check if user has logged in
        if (Auth::check()) {
            // Check if selected product is in order history (Library) of user
            $isOwned = \App\Models\OrderItem::where('product_id', $product->id)
                                ->whereHas('order', function($query) { // Use whereHas to query the relationship
                                $query->where('user_id', Auth::id());
                            })
                            ->exists();
        }

        // Transmit variable $isOwned into View
        return view('home.homeProductShow', compact('product', 'isOwned'));
    }
}
