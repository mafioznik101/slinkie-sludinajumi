<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'profile_id', 'rating', 'content'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function profile()
	{
		return $this->belongsTo(Profile::class);
	}
}
