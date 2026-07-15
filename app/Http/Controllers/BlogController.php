<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Show approved blogs on the public homepage.
     */
    public function home()
    {
        $blogs = Blog::with('user')
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('welcome', compact('blogs'));
    }

    /**
     * Show the blog management page.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            // Admin can see all blogs.
            $blogs = Blog::with('user')
                ->latest()
                ->get();
        } else {
            // Author can only see their own blogs.
            $blogs = Blog::with('user')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the create-blog form.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Save a new blog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $image = $request->file('image');

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $imageName);

        $blog = new Blog();
        $blog->user_id = $user->id;
        $blog->image = $imageName;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = 'pending';
        $blog->save();

        return redirect()->route('blogs.index')
            ->with(
                'success',
                'Blog submitted and waiting for admin approval.'
            );
    }

    /**
     * Show one approved blog.
     */
    public function show(Blog $blog)
    {
        if ($blog->status !== 'approved') {
            abort(404);
        }

        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the edit-blog form.
     */
    public function edit(Blog $blog)
    {
        $this->checkBlogAccess($blog);

        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update a blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $this->checkBlogAccess($blog);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images'), $imageName);

            $blog->image = $imageName;
        }

        $blog->title = $request->title;
        $blog->content = $request->content;

        /** @var User $user */
        $user = Auth::user();

        // When an author edits a blog,
        // the blog needs admin approval again.
        if ($user->hasRole('author')) {
            $blog->status = 'pending';
        }

        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Delete a blog.
     */
    public function destroy(Blog $blog)
    {
        $this->checkBlogAccess($blog);

        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Approve a blog.
     * Admin only.
     */
    public function approve(Blog $blog)
    {
        $blog->status = 'approved';
        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog approved successfully.');
    }

    /**
     * Reject a blog.
     * Admin only.
     */
    public function reject(Blog $blog)
    {
        $blog->status = 'rejected';
        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog rejected successfully.');
    }

    /**
     * Admin can manage all blogs.
     * Authors can only manage their own blogs.
     */
    private function checkBlogAccess(Blog $blog)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return;
        }

        if ($blog->user_id !== $user->id) {
            abort(403);
        }
    }
}