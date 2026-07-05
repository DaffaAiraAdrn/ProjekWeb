<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'abstract',
        'introduction',
        'methodology',
        'results',
        'conclusion',
        'references',
        'attachments',
        'cover_image',
        'status',
        'published_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Report $report) {
            if (empty($report->slug) || $report->isDirty('title')) {
                $report->slug = $report->generateUniqueSlug($report->title);
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }
}
