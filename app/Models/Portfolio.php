<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'content',
        'thumbnail',
        'images',
        'featured',
        'order',
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Portfolio $portfolio) {
            if (empty($portfolio->slug) || $portfolio->isDirty('title')) {
                $portfolio->slug = $portfolio->generateUniqueSlug($portfolio->title);
            }
        });
    }

    public function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
