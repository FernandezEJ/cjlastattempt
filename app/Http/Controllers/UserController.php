<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show all registered users.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Change a user into an author
     * or change an author back into a user.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,author',
        ]);

        // The admin account cannot be changed here.
        if ($user->hasRole('admin')) {
            return redirect()->route('users.index')
                ->with('error', 'The admin role cannot be changed.');
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', 'User role updated successfully.');
    }
}