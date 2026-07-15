<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Count approved blog posts.
        $approvedPosts = Blog::where('status', 'approved')->count();

        // Count pending blog posts.
        $pendingPosts = Blog::where('status', 'pending')->count();

        // Count all registered users.
        $totalUsers = User::count();

        // Count users with the author role.
        $totalAuthors = User::role('author')->count();

        return view('dashboard', compact(
            'approvedPosts',
            'pendingPosts',
            'totalUsers',
            'totalAuthors'
        ));
    }
}