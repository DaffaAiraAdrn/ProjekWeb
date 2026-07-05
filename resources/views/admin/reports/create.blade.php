@extends('layouts.admin')

@section('title', 'New Report')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Report</h1>
        <p class="page-subtitle">Add a new research or technical report.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Report title" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Abstract <span class="req">*</span></label>
            <div id="editor-abstract"></div>
            <input type="hidden" name="abstract" id="abstract-input" value="{{ old('abstract') }}">
            @error('abstract') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Introduction</label>
            <div id="editor-introduction"></div>
            <input type="hidden" name="introduction" id="introduction-input" value="{{ old('introduction') }}">
            @error('introduction') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Methodology</label>
            <div id="editor-methodology"></div>
            <input type="hidden" name="methodology" id="methodology-input" value="{{ old('methodology') }}">
            @error('methodology') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Results</label>
            <div id="editor-results"></div>
            <input type="hidden" name="results" id="results-input" value="{{ old('results') }}">
            @error('results') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Conclusion</label>
            <div id="editor-conclusion"></div>
            <input type="hidden" name="conclusion" id="conclusion-input" value="{{ old('conclusion') }}">
            @error('conclusion') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">References</label>
            <div id="editor-references"></div>
            <input type="hidden" name="references" id="references-input" value="{{ old('references') }}">
            @error('references') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Cover Image</label>
            <div class="upload-zone" onclick="document.getElementById('cover_image').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload cover image<br>PNG, JPG, WEBP up to 5MB</p>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" onchange="previewSingle(this, 'cover-preview')">
            </div>
            <div id="cover-preview" class="preview-grid" style="display:none;"></div>
            @error('cover_image') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Attachments</label>
            <div class="upload-zone" onclick="document.getElementById('attachments').click()">
                <i class="fas fa-paperclip"></i>
                <p>Click to upload attachments<br>PDF, DOCX, PNG, JPG up to 20MB each</p>
                <input type="file" name="attachments[]" id="attachments" accept=".pdf,.docx,.png,.jpg,.jpeg" multiple onchange="previewFiles(this, 'att-preview')">
            </div>
            <div id="att-preview" style="margin-top:1rem;"></div>
            @error('attachments') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Report</button>
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
</script>
@endpush
@endsection
