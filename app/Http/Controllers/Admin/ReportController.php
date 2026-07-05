<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $reports = $query->latest()->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'introduction' => 'nullable|string',
            'methodology' => 'nullable|string',
            'results' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'references' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only([
            'title', 'abstract', 'introduction', 'methodology',
            'results', 'conclusion', 'references', 'status'
        ]);
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploadFile($request->file('cover_image'), 'reports/covers');
        }

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $attachments[] = $this->uploadFile($attachment, 'reports/attachments');
            }
        }
        $data['attachments'] = $attachments;

        Report::create($data);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report created successfully.');
    }

    public function show(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'introduction' => 'nullable|string',
            'methodology' => 'nullable|string',
            'results' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'references' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only([
            'title', 'abstract', 'introduction', 'methodology',
            'results', 'conclusion', 'references', 'status'
        ]);
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;

        if ($request->hasFile('cover_image')) {
            $this->deleteFile($report->cover_image);
            $data['cover_image'] = $this->uploadFile($request->file('cover_image'), 'reports/covers');
        }

        if ($request->hasFile('attachments')) {
            $attachments = $report->attachments ?? [];
            foreach ($request->file('attachments') as $attachment) {
                $attachments[] = $this->uploadFile($attachment, 'reports/attachments');
            }
            $data['attachments'] = $attachments;
        }

        $report->update($data);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $this->deleteFile($report->cover_image);

        if ($report->attachments) {
            foreach ($report->attachments as $attachment) {
                $this->deleteFile($attachment);
            }
        }

        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report deleted successfully.');
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
