<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', $this->likeOperator(), '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(10);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'status']);
        $data['published_at'] = $this->resolvePublishedAt($request);

        if ($request->filled('tags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->tags)));
            $data['tags'] = $tags;
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->uploadFile($request->file('featured_image'), 'blog');
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(BlogPost $blogPost)
    {
        return view('admin.blog.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'status']);
        $data['published_at'] = $this->resolvePublishedAt($request, $blogPost);

        if ($request->filled('tags')) {
            $tags = array_filter(array_map('trim', explode(',', $request->tags)));
            $data['tags'] = $tags;
        }

        if ($request->hasFile('featured_image')) {
            $this->deleteFile($blogPost->featured_image);
            $data['featured_image'] = $this->uploadFile($request->file('featured_image'), 'blog');
        }

        $blogPost->update($data);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $this->deleteFile($blogPost->featured_image);
        $blogPost->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    /**
     * A published post needs a published_at timestamp: scopePublished()
     * filters on `published_at <= now()`, so leaving it null would keep the
     * post invisible on the public site.
     */
    private function resolvePublishedAt(Request $request, ?BlogPost $post = null)
    {
        if ($request->filled('published_at')) {
            return $request->published_at;
        }

        if ($request->status === 'published') {
            return $post?->published_at ?? now();
        }

        return null;
    }

    /**
     * PostgreSQL needs ILIKE for a case-insensitive match; MySQL's LIKE is
     * already case-insensitive and rejects ILIKE as a syntax error.
     */
    private function likeOperator(): string
    {
        return BlogPost::query()->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
    }

    private function uploadFile($file, string $directory): string
    {
        $uploadPath = public_path('uploads/' . $directory);
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/' . $directory . '/' . $filename;
    }

    private function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
