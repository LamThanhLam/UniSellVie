<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('products.create');
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
            'platform' => 'nullable',
            'genre' => 'nullable',
            'price' => 'required|numeric', 
        ]);

        // Save data into database
        Product::create($request->all());

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
        return view('products.edit', compact('product'));
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
            'platform' => 'nullable',
            'genre' => 'nullable',
            'price' => 'required|numeric',
        ]);

        $product->update($request->all());

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
