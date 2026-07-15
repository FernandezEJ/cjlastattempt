<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogLike;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Like or unlike a blog.
     */
    public function toggle(Blog $blog)
    {
        // Only approved blogs can be liked.
        if ($blog->status !== 'approved') {
            abort(404);
        }

        /** @var User $user */
        $user = Auth::user();

        $existingLike = BlogLike::where('blog_id', $blog->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();

            return redirect()
                ->route('blogs.show', $blog)
                ->with('success', 'Like removed.');
        }

        BlogLike::create([
            'blog_id' => $blog->id,
            'user_id' => $user->id,
        ]);

        return redirect()
            ->route('blogs.show', $blog)
            ->with('success', 'Blog liked successfully.');
    }
}