<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function home(Request $request)
    {
        $query = Blog::with(['user', 'categoryData'])
            ->withCount(['likes', 'comments'])
            ->where('status', 'approved');

        // Search by title or author.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($blogQuery) use ($search) {
                $blogQuery
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );
                    });
            });
        }

        // Filter by category.
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $categories = Category::orderBy('name')->get();

        $blogs = $query
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('welcome', compact('blogs', 'categories'));
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $blogs = Blog::with(['user', 'categoryData'])
                ->withCount(['likes', 'comments'])
                ->latest()
                ->get();
        } else {
            $blogs = Blog::with(['user', 'categoryData'])
                ->withCount(['likes', 'comments'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
        ]);

        if (trim(strip_tags($request->content)) === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'content' => 'The blog content is required.',
                ]);
        }

        /** @var User $user */
        $user = Auth::user();

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $imageName);

        $blog = new Blog();
        $blog->user_id = $user->id;
        $blog->category_id = $request->category_id;
        $blog->image = $imageName;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = 'pending';
        $blog->views = 0;
        $blog->save();

        return redirect()->route('blogs.index')
            ->with(
                'success',
                'Blog submitted and waiting for admin approval.'
            );
    }

    public function show(Blog $blog)
    {
        if ($blog->status !== 'approved') {
            abort(404);
        }

        $blog->increment('views');

        $blog->load([
            'user',
            'categoryData',
            'comments.user',
        ]);

        $blog->loadCount([
            'likes',
            'comments',
        ]);

        $userHasLiked = false;

        if (Auth::check()) {
            $userHasLiked = $blog->likes()
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('blogs.show', compact(
            'blog',
            'userHasLiked'
        ));
    }

    public function edit(Blog $blog)
    {
        $this->checkBlogAccess($blog);

        $categories = Category::orderBy('name')->get();

        return view('blogs.edit', compact(
            'blog',
            'categories'
        ));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->checkBlogAccess($blog);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
        ]);

        if (trim(strip_tags($request->content)) === '') {
            return back()
                ->withInput()
                ->withErrors([
                    'content' => 'The blog content is required.',
                ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images'), $imageName);

            $blog->image = $imageName;
        }

        $blog->title = $request->title;
        $blog->category_id = $request->category_id;
        $blog->content = $request->content;

        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('author')) {
            $blog->status = 'pending';
        }

        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->checkBlogAccess($blog);

        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    public function approve(Blog $blog)
    {
        $blog->status = 'approved';
        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog approved successfully.');
    }

    public function reject(Blog $blog)
    {
        $blog->status = 'rejected';
        $blog->save();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog rejected successfully.');
    }

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