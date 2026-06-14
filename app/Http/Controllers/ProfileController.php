<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['profile', 'posts' => fn($q) => $q->where('is_active', true)->latest(), 'reviews.reviewer']);
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $user->load('profile');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bio'   => 'nullable|string|max:500',
            'city'  => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->profile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('profile.show', Auth::user())->with('success', 'Profils atjaunināts!');
    }
}