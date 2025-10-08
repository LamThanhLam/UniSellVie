<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $platforms = Platform::latest()->paginate(10);
        return view('platforms.index', compact('platforms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:platforms,name|max:255',
        ]);

        Platform::create($request->all());

        return redirect()->route('platforms.index')
                        ->with('success', 'Platform has been added successfully.');
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Platform $platform)
    {
        return view('platforms.edit', compact('platform'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            // Excludes current ID in order not to get the same name when updating
            'name' => 'required|unique:platforms,name,'.$platform->id.'|max:255', 
        ]);

        $platform->update($request->all());

        return redirect()->route('platforms.index')
                        ->with('success', 'Platform has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Platform $platform)
    {
        $platform->delete();

        return redirect()->route('platforms.index')
                        ->with('success', 'Platform has been deleted successfully.');
    }
}
