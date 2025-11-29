<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // Require 'admin' middleware for all methods
        $this->middleware('admin'); 
    }

    public function index()
    {
        // Get all users except the current Admin user
        $users = User::where('id', '!=', Auth::id())->paginate(10); 
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Security check: Admin cannot change their own role
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate(['role' => 'required|integer|min:0|max:2']);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role has been updated successfully.');
    }
}