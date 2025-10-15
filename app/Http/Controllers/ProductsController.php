<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;
use App\Http\Requests\StoreProductRequest; // You will need this Form Request if you ever wanted to use the request syntax
use App\Http\Requests\UpdateProductRequest; // The same with the above and also rememer to create them in the terminal
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Take searching keyword from URL
        $search = $request->input('search');

        // Start a builder query for Product model
        $query = Product::query();

        // If there is a searching keyword, then add searching condition into query
        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('developer', 'like', "%{$search}%")
                ->orWhere('publisher', 'like', "%{$search}%");
        }

        // Slit result page
        $products = $query->paginate(10);

        // Return view with data allocated in slit page
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = Platform::all(); // Get all Platforms
        $genres = Genre::all();       // Get all Genres

        return view('products.create', compact('platforms', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'releaseDate' => 'required|date',
            'description' => 'nullable',
            'content' => 'nullable',
            'system_requirements' => 'nullable',
            'price' => 'required|numeric', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'platform_ids' => 'required|array', // Must have this field from form
            'platform_ids.*' => 'exists:platforms,id', // Check the existence of ID
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        // 1. Creates product
        $product = Product::create($request->except(['platform_ids', 'genre_ids'])); 

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
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $platforms = Platform::all(); // Get all Platforms
        $genres = Genre::all();       // Get all Genres
        
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
        $request->validate([
            'title' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'releaseDate' => 'required|date',
            'description' => 'nullable',
            'content' => 'nullable',
            'system_requirements' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'platform_ids' => 'required|array',
            'platform_ids.*' => 'exists:platforms,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        // 1. Update main fields
        $product->update($request->except(['platform_ids', 'genre_ids']));

        // 2. Synchronize relationships
        $product->platforms()->sync($request->input('platform_ids'));
        $product->genres()->sync($request->input('genre_ids'));

        return redirect()->route('products.index')->with('success', 'This product has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
