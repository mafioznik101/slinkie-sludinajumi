<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'is_active',
        'user_id',
        'category_id',
        'title_image',
        'sub_images',
    ];

    protected $casts = [
        'sub_images' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Post $post) {
            if ($post->title_image) {
                Storage::disk('public')->delete($post->title_image);
            }
            if (is_array($post->sub_images)) {
                foreach ($post->sub_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        });
    }

    public function titleImageUrl(): ?string
    {
        return $this->title_image
            ? Storage::disk('public')->url($this->title_image)
            : null;
    }

    public function subImageUrls(): array
    {
        if (! is_array($this->sub_images)) {
            return [];
        }

        return array_map(
            fn (string $path) => Storage::disk('public')->url($path),
            $this->sub_images
        );
    }

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
