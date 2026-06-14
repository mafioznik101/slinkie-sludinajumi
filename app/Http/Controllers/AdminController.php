<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    private function requireAdmin(): void
    {
        abort_unless(auth()->user()?->isAdmin(), 403, 'Tikai administratoriem.');
    }

    public function index()
    {
        $this->requireAdmin();

        $users = User::withCount('posts')->latest()->get();
        $posts = Post::with(['user', 'category'])->latest()->get();

        return view('admin.index', compact('users', 'posts'));
    }

    public function blockUser(User $user)
    {
        $this->requireAdmin();

        $user->update(['is_blocked' => !$user->is_blocked]);

        return back()->with(
            'success',
            $user->is_blocked ? 'Lietotājs bloķēts.' : 'Lietotājs atbloķēts.'
        );
    }

    public function destroyUser(User $user)
    {
        $this->requireAdmin();

        $user->delete();

        return back()->with('success', 'Lietotājs dzēsts.');
    }

    public function destroyPost(Post $post)
    {
        $this->requireAdmin();

        $post->delete();

        return back()->with('success', 'Sludinājums dzēsts.');
    }
}