@extends('layouts.admin')

@section('title', 'Edit: ' . $report->title)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Report</h1>
        <p class="page-subtitle">{{ $report->title }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.reports.update', $report) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $report->title) }}" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Abstract <span class="req">*</span></label>
            <div id="editor-abstract"></div>
            <input type="hidden" name="abstract" id="abstract-input" value="{{ old('abstract', $report->abstract) }}">
            @error('abstract') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Introduction</label>
            <div id="editor-introduction"></div>
            <input type="hidden" name="introduction" id="introduction-input" value="{{ old('introduction', $report->introduction) }}">
            @error('introduction') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Methodology</label>
            <div id="editor-methodology"></div>
            <input type="hidden" name="methodology" id="methodology-input" value="{{ old('methodology', $report->methodology) }}">
            @error('methodology') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Results</label>
            <div id="editor-results"></div>
            <input type="hidden" name="results" id="results-input" value="{{ old('results', $report->results) }}">
            @error('results') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Conclusion</label>
            <div id="editor-conclusion"></div>
            <input type="hidden" name="conclusion" id="conclusion-input" value="{{ old('conclusion', $report->conclusion) }}">
            @error('conclusion') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">References</label>
            <div id="editor-references"></div>
            <input type="hidden" name="references" id="references-input" value="{{ old('references', $report->references) }}">
            @error('references') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Cover Image</label>
            @if(!empty($report->cover_image))
                <div class="preview-grid" style="display:grid;">
                    <div class="preview-item">
                        <img src="{{ asset('storage/' . $report->cover_image) }}" alt="Cover image">
                    </div>
                </div>
            @else
                <p class="form-help">No cover image set.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Replace Cover Image</label>
            <div class="upload-zone" onclick="document.getElementById('cover_image').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload a new cover image</p>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewSingle(this, 'cover-preview')">
            </div>
            <div id="cover-preview" class="preview-grid" style="display:none;"></div>
            @error('cover_image') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Attachments</label>
            @if(!empty($report->attachments) && count($report->attachments) > 0)
                @foreach($report->attachments as $attachment)
                    <div class="preview-file" id="att-{{ $attachment->id ?? $loop->index }}">
                        <i class="fas {{ getAttachmentIcon($attachment->file_type ?? 'file') }}"></i>
                        <div class="file-info">
                            <div class="file-name">{{ $attachment->file_name ?? $attachment->name ?? 'Attachment' }}</div>
                            <div class="file-size">{{ $attachment->file_size ?? '' }}</div>
                        </div>
                        <a href="{{ asset('storage/' . ($attachment->path ?? $attachment)) }}" download class="btn-icon" title="Download"><i class="fas fa-download"></i></a>
                        <button type="button" class="btn-icon danger" onclick="deleteAttachment({{ $attachment->id ?? 'null' }}, this)" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                @endforeach
            @else
                <p class="form-help">No attachments uploaded.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Add More Attachments</label>
            <div class="upload-zone" onclick="document.getElementById('attachments').click()">
                <i class="fas fa-paperclip"></i>
                <p>Click to upload additional files<br>PDF, DOCX, PNG, JPG up to 20MB each</p>
                <input type="file" name="attachments[]" id="attachments" accept=".pdf,.docx,.png,.jpg,.jpeg" multiple onchange="previewFiles(this, 'att-preview')">
            </div>
            <div id="att-preview" style="margin-top:1rem;"></div>
            @error('attachments') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function initEditor(selector, inputId) {
        var quill = new Quill(selector, {
            theme: 'snow',
            modules: { toolbar: [['bold','italic','underline'],[{ 'header': [2,3,4,false] }],['code-block','blockquote'],['link'],['clean']] }
        });
        var input = document.getElementById(inputId);
        if (input.value) quill.root.innerHTML = input.value;
        quill.on('text-change', function() { input.value = quill.root.innerHTML; });
        return quill;
    }
    initEditor('#editor-abstract', 'abstract-input');
    initEditor('#editor-introduction', 'introduction-input');
    initEditor('#editor-methodology', 'methodology-input');
    initEditor('#editor-results', 'results-input');
    initEditor('#editor-conclusion', 'conclusion-input');
    initEditor('#editor-references', 'references-input');

    function previewSingle(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) { preview.style.display = 'none'; return; }
        preview.innerHTML = '';
        var reader = new FileReader();
        reader.onload = function(e) {
            var div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = '<img src="' + e.target.result + '"><button type="button" class="preview-remove" onclick="this.parentElement.remove();document.getElementById(\'cover_image\').value=\'\';"><i class="fas fa-times"></i></button>';
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
        preview.style.display = 'grid';
    }

    function previewFiles(input, previewId) {
        var preview = document.getElementById(previewId);
        preview.innerHTML = '';
        var icons = { pdf: 'fa-file-pdf', docx: 'fa-file-word', png: 'fa-file-image', jpg: 'fa-file-image', jpeg: 'fa-file-image' };
        Array.from(input.files).forEach(function(file) {
            var ext = file.name.split('.').pop().toLowerCase();
            var icon = icons[ext] || 'fa-file';
            var div = document.createElement('div');
            div.className = 'preview-file';
            div.innerHTML = '<i class="fas ' + icon + '"></i><div class="file-info"><div class="file-name">' + file.name + '</div><div class="file-size">' + formatSize(file.size) + '</div></div><button type="button" class="btn-icon danger" onclick="this.parentElement.remove();"><i class="fas fa-times"></i></button>';
            preview.appendChild(div);
        });
    }
    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes/1024).toFixed(1) + ' KB';
        return (bytes/1048576).toFixed(1) + ' MB';
    }

    function deleteAttachment(id, btn) {
        if (!confirm('Delete this attachment?')) return;
        if (id) {
            fetch('{{ url("/admin/reports/attachments") }}/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(function() { btn.parentElement.remove(); });
        } else {
            btn.parentElement.remove();
        }
    }
</script>
@endpush

@php
    function getAttachmentIcon($type) {
        $type = strtolower($type);
        if (str_contains($type, 'pdf')) return 'fa-file-pdf';
        if (str_contains($type, 'doc') || str_contains($type, 'word')) return 'fa-file-word';
        if (str_contains($type, 'png') || str_contains($type, 'jpg') || str_contains($type, 'jpeg') || str_contains($type, 'image')) return 'fa-file-image';
        return 'fa-file';
    }
@endphp
@endsection
