<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Post $post)
    {
        // 1. Validate that the comment text isn't empty
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // 2. Save the comment, linking it to the current user and the target post
        Comment::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),   // The logged-in user's ID
            'post_id' => $post->id,    // The ID from the URL parameter {post}
        ]);

        // 3. Send them back to the post view with a success message
        return back()->with('success', 'Komentārs pievienots!');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        // Safety Check: Make sure the logged-in user owns the comment (or is an admin)
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Delete it from MySQL
        $comment->delete();

        return back()->with('success', 'Komentārs dzēsts!');
    }
}