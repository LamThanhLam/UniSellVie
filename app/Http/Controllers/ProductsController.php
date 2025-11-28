<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Genre;
use App\Models\Platform;

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
            'image' => 'nullable|max:2048', // Validation: ONLY TEST FILE SIZE
            
            // Validation for relationships
            'platform_ids' => 'required|array', 
            'platform_ids.*' => 'exists:platforms,id', 
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $input = $request->except(['platform_ids', 'genre_ids']);

        // CRITICAL FIX: Processing uploaded image and ensuring it saves to the PUBLIC folder
        if ($image = $request->file('image')) {
            $destinationPath = public_path('images/'); // CORRECT PATH: points to public/images
            
            // Create directory if it doesn't exist
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage; // Store ONLY the filename
        }

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
        return view('products.show', compact('product'));
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
            'image' => 'nullable|max:2048', // Validation: ONLY TEST FILE SIZE

            // Validation for relationships
            'platform_ids' => 'required|array',
            'platform_ids.*' => 'exists:platforms,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $input = $request->except(['platform_ids', 'genre_ids']);

        // Process image uploading
        if ($image = $request->file('image')) {
            $destinationPath = public_path('images/'); // CORRECT PATH: points to public/images

            // Ensure the directory exists
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            // Logic for DELETE OLD IMAGE (Only delete if a file exists and is being replaced)
            if ($product->image && File::exists(public_path('images/' . $product->image))) {
                File::delete(public_path('images/' . $product->image));
            }
            
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        } else {
            // Keep the old image if there is no new image uploaded
            unset($input['image']);
        }

        // 1. Update main fields
        $product->update($input);

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
        // Delete the image file from the public folder first
        if ($product->image && File::exists(public_path('images/' . $product->image))) {
            File::delete(public_path('images/' . $product->image));
        }
        
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}