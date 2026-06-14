<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('posts.index');
    }

	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email'    => 'required|email',
			'password' => 'required',
		]);

		if (Auth::attempt($credentials)) {
			if (Auth::user()->is_blocked) {
				Auth::logout();
				return back()->withErrors(['email' => 'Šis konts ir bloķēts.']);
			}

			$request->session()->regenerate();
			return redirect()->intended(route('posts.index'));
		}

		return back()->withErrors(['email' => 'Nepareizs e-pasts vai parole.']);
	}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}