<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|min:10',
            'type' => 'required|in:service,job',
            'category_id' => 'required|exists:categories,id',
        ]);

        Post::create($validated + [
            'user_id' => Auth::id(),
            'is_active' => true,
        ]);

        return redirect()->route('posts.index')->with('success', 'Sludinājums izveidots veiksmīgi.');
    }

    public function show(Post $post)
    {
        $post->load(['user.profile', 'category', 'comments.user']);
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string|min:10',
            'type' => 'required|in:service,job',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'nullable|boolean',
        ]);

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category_id' => $validated['category_id'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('posts.show', $post)->with('success', 'Sludinājums atjaunināts.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Sludinājums dzēsts.');
    }

    public function search(Request $request)
    {
        $query = Post::with(['user', 'category'])->where('is_active', true);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->get();

        return view('posts.index', compact('posts'));
    }
}