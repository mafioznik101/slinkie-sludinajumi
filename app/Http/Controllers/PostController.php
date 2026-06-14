<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
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
            'title_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sub_images' => 'nullable|array|max:3',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $titleImagePath = $request->file('title_image')->store('posts', 'public');

        $subImages = [];
        if ($request->hasFile('sub_images')) {
            foreach ($request->file('sub_images') as $image) {
                $subImages[] = $image->store('posts', 'public');
            }
        }

        Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'is_active' => true,
            'title_image' => $titleImagePath,
            'sub_images' => $subImages,
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
            'title_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sub_images' => 'nullable|array|max:3',
            'sub_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category_id' => $validated['category_id'],
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('title_image')) {
            if ($post->title_image) {
                Storage::disk('public')->delete($post->title_image);
            }
            $data['title_image'] = $request->file('title_image')->store('posts', 'public');
        }

        if ($request->hasFile('sub_images')) {
            if (is_array($post->sub_images)) {
                foreach ($post->sub_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $subImages = [];
            foreach ($request->file('sub_images') as $image) {
                $subImages[] = $image->store('posts', 'public');
            }
            $data['sub_images'] = $subImages;
        }

        $post->update($data);

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
