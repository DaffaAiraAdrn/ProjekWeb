<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|max:10240',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $uploadPath = public_path('uploads/media');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        $filePath = 'uploads/media/' . $filename;

        Media::create([
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'alt_text' => $request->alt_text,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'File uploaded successfully.');
    }

    public function destroy(Media $media)
    {
        $fullPath = public_path($media->file_path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'File deleted successfully.');
    }
}
