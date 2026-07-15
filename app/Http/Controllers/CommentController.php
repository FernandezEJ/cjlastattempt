<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Save a new comment.
     */
    public function store(Request $request, Blog $blog)
    {
        // Comments are allowed only on approved blogs.
        if ($blog->status !== 'approved') {
            abort(404);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        /** @var User $user */
        $user = Auth::user();

        Comment::create([
            'blog_id' => $blog->id,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        return redirect()
            ->route('blogs.show', $blog)
            ->with('success', 'Comment added successfully.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        /** @var User $user */
        $user = Auth::user();

        // Admin can delete any comment.
        // A normal user can delete only their own comment.
        if (
            ! $user->hasRole('admin')
            && $comment->user_id !== $user->id
        ) {
            abort(403);
        }

        $blog = $comment->blog;

        $comment->delete();

        return redirect()
            ->route('blogs.show', $blog)
            ->with('success', 'Comment deleted successfully.');
    }
}