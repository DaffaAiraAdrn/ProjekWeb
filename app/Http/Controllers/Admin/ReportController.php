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
            $query->where('title', $this->likeOperator(), '%' . $request->search . '%');
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.reports.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $data = $request->only([
            'title', 'abstract', 'introduction', 'methodology',
            'results', 'conclusion', 'references', 'status'
        ]);
        $data['published_at'] = $this->resolvePublishedAt($request);

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
        $request->validate($this->rules());

        $data = $request->only([
            'title', 'abstract', 'introduction', 'methodology',
            'results', 'conclusion', 'references', 'status'
        ]);
        $data['published_at'] = $this->resolvePublishedAt($request, $report);

        if ($request->hasFile('cover_image')) {
            $this->deleteFile($report->cover_image);
            $data['cover_image'] = $this->uploadFile($request->file('cover_image'), 'reports/covers');
        }

        // Start from the attachments the admin did not tick for removal, then
        // append whatever was just uploaded.
        $attachments = $report->attachments ?? [];
        $removed = $request->input('remove_attachments', []);

        if (!empty($removed)) {
            foreach ($removed as $path) {
                $this->deleteFile($path);
            }
            $attachments = array_values(array_diff($attachments, $removed));
        }

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $attachments[] = $this->uploadFile($attachment, 'reports/attachments');
            }
        }

        $data['attachments'] = $attachments;

        $report->update($data);

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $this->deleteFile($report->cover_image);

        foreach ($report->attachments ?? [] as $attachment) {
            $this->deleteFile($attachment);
        }

        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    /**
     * Validation rules shared by store() and update().
     *
     * The attachment mime list mirrors the `accept` attribute on the upload
     * field in the create/edit forms — images are allowed there too.
     */
    private function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'introduction' => 'nullable|string',
            'methodology' => 'nullable|string',
            'results' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'references' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,png,jpg,jpeg|max:10240',
            'remove_attachments' => 'nullable|array',
            'remove_attachments.*' => 'string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * A published report needs a published_at timestamp: scopePublished()
     * filters on `published_at <= now()`, so leaving it null would keep the
     * report invisible on the public site.
     */
    private function resolvePublishedAt(Request $request, ?Report $report = null)
    {
        if ($request->filled('published_at')) {
            return $request->published_at;
        }

        if ($request->status === 'published') {
            return $report?->published_at ?? now();
        }

        return null;
    }

    /**
     * PostgreSQL needs ILIKE for a case-insensitive match; MySQL's LIKE is
     * already case-insensitive and rejects ILIKE as a syntax error.
     */
    private function likeOperator(): string
    {
        return Report::query()->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
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
