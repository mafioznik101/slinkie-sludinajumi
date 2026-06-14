<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'bio', 'phone', 'city'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
}
