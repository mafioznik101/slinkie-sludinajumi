<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Nevar atsaukties pašam sev.');
        }

        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'reviewer_id' => Auth::id(),
            'user_id'     => $user->id,
            'rating'      => $validated['rating'],
            'content'     => $validated['content'],
        ]);

        return back()->with('success', 'Atsauksme pievienota!');
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->reviewer_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Atsauksme dzēsta!');
    }
}