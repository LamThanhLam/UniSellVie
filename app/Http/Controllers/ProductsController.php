<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\OrderItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Required for file existence and deletion
use Illuminate\Support\Facades\Storage; // Optional, but good practice

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start Product query
        $query = Product::query();
        
        // Add Searching condition based on user input
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Slit page and Eager Load relationships
        $products = $query->with('platforms', 'genres')->paginate(10);

        // Return view with data allocated in slit page
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = Platform::all(); // Get all Platforms
        $genres = Genre::all(); // Get all Genres

        return view('products.create', compact('platforms', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Required fields
            'title' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'releaseDate' => 'required|date',
            'price' => 'required|numeric', 

            // Nullable fields
            'description' => 'nullable',
            'content' => 'nullable',
            'system_requirements' => 'nullable',
            
            // Validation for relationships
            'platform_ids' => 'required|array', 
            'platform_ids.*' => 'exists:platforms,id', 
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $input = $request->except(['platform_ids', 'genre_ids']);

        // Very important: Assign the product owner as the current user
        $input['user_id'] = Auth::id(); // Needed

        // 1. Creates product
        $product = Product::create($input);

        // 2. Saves the relationship
        $product->platforms()->attach($request->input('platform_ids'));
        $product->genres()->attach($request->input('genre_ids'));

        return redirect()->route('products.index')
                         ->with('success', 'This product has been added successfully.');
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
        return view('products.show', compact('product', 'isOwned'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $platforms = Platform::all(); // Get all Platforms
        $genres = Genre::all(); // Get all Genres
        
        // Get ID of all selected Platform and Genre for this product
        $productPlatforms = $product->platforms->pluck('id')->toArray();
        $productGenres = $product->genres->pluck('id')->toArray();

        return view('products.edit', compact('product', 'platforms', 'genres', 'productPlatforms', 'productGenres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $request->validate([
            // Required fields
            'title' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'releaseDate' => 'required|date',
            'price' => 'required|numeric',

            // Nullable fields
            'description' => 'nullable',
            'content' => 'nullable',
            'system_requirements' => 'nullable',

            // Validation for relationships
            'platform_ids' => 'required|array',
            'platform_ids.*' => 'exists:platforms,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $input = $request->except(['platform_ids', 'genre_ids']);

        // 1. Update main fields
        $product->update($request->validated());

        // 2. Synchronize relationships
        $product->platforms()->sync($request->input('platform_ids'));
        $product->genres()->sync($request->input('genre_ids'));

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}