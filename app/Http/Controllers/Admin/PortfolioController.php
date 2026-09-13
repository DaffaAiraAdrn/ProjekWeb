<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('title', $this->likeOperator(), '%' . $request->search . '%');
        }

        $portfolios = $query->orderBy('order')->latest()->paginate(10);

        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:3D,ML,Programming',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $data = $request->only(['title', 'category', 'description', 'content', 'order']);
        $data['featured'] = $request->boolean('featured');
        $data['order'] = $request->integer('order', 0);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'portfolios/thumbnails');
        }

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->uploadFile($image, 'portfolios/images');
            }
        }
        $data['images'] = $images;

        Portfolio::create($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolio.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:3D,ML,Programming',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'string',
        ]);

        $data = $request->only(['title', 'category', 'description', 'content', 'order']);
        $data['featured'] = $request->boolean('featured');
        $data['order'] = $request->integer('order', 0);

        if ($request->hasFile('thumbnail')) {
            $this->deleteFile($portfolio->thumbnail);
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), 'portfolios/thumbnails');
        }

        // Start from the images the admin did not tick for removal, then append
        // whatever was just uploaded.
        $images = $portfolio->images ?? [];
        $removed = $request->input('remove_images', []);

        if (!empty($removed)) {
            foreach ($removed as $path) {
                $this->deleteFile($path);
            }
            $images = array_values(array_diff($images, $removed));
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->uploadFile($image, 'portfolios/images');
            }
        }

        $data['images'] = $images;

        $portfolio->update($data);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteFile($portfolio->thumbnail);

        if ($portfolio->images) {
            foreach ($portfolio->images as $image) {
                $this->deleteFile($image);
            }
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }

    /**
     * PostgreSQL needs ILIKE for a case-insensitive match; MySQL's LIKE is
     * already case-insensitive and rejects ILIKE as a syntax error.
     */
    private function likeOperator(): string
    {
        return Portfolio::query()->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
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
