<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function __construct()
    {
        // Require user to log in to view the library
        $this->middleware('auth'); 
    }

    public function index()
    {
        // Get all OrderItem (purchased games) of current user
        // Sort by latest purchase date
        $libraryItems = OrderItem::where('user_id', Auth::id())
                                 ->with('product') // Load relevant game information
                                 ->latest() // Sort by create date (purchase) descending
                                 ->paginate(10); 

        return view('library.index', compact('libraryItems'));
    }
}
