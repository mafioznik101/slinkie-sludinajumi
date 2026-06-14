<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->user() || !$request->user()->isAdmin()) {
                abort(403, 'Tikai administratoriem.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::withCount('posts')->latest()->get();
        $posts = Post::with(['user', 'category'])->latest()->get();
        return view('admin.index', compact('users', 'posts'));
    }

    public function blockUser(User $user)
    {
        $user->update(['is_blocked' => !$user->is_blocked]);
        $msg = $user->is_blocked ? 'Lietotājs bloķēts.' : 'Lietotājs atbloķēts.';
        return back()->with('success', $msg);
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Lietotājs dzēsts.');
    }

    public function destroyPost(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Sludinājums dzēsts.');
    }
}