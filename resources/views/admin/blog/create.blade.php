@extends('layouts.admin')

@section('title', 'New Blog Post')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Blog Post</h1>
        <p class="page-subtitle">Write a new article for your blog.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Post title" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="excerpt">Excerpt</label>
            <textarea name="excerpt" id="excerpt" class="form-control" rows="2" placeholder="A short summary shown in the blog list.">{{ old('excerpt') }}</textarea>
            @error('excerpt') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content <span class="req">*</span></label>
            <div id="editor-content"></div>
            <input type="hidden" name="content" id="content-input" value="{{ old('content') }}">
            @error('content') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Featured Image</label>
            <div class="upload-zone" onclick="document.getElementById('featured_image').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload featured image<br>PNG, JPG, WEBP up to 5MB</p>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" onchange="previewSingle(this, 'img-preview')">
            </div>
            <div id="img-preview" class="preview-grid" style="display:none;"></div>
            @error('featured_image') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="tags">Tags</label>
                <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags') }}" placeholder="comma, separated, tags">
                <div class="form-help">Separate tags with commas.</div>
                @error('tags') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status <span class="req">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="published_at">Publish Date</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}">
            <div class="form-help">Leave empty to publish immediately when status is "Published".</div>
            @error('published_at') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Post</button>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    var quillContent = new Quill('#editor-content', {
        theme: 'snow',
        modules: { toolbar: [['bold','italic','underline'],[{ 'header': [2,3,4,false] }],['code-block','blockquote'],['link','image'],['clean']] }
    });
    var contentInput = document.getElementById('content-input');
    if (contentInput.value) quillContent.root.innerHTML = contentInput.value;
    quillContent.on('text-change', function() { contentInput.value = quillContent.root.innerHTML; });

    function previewSingle(input, previewId) {
        var preview = document.getElementById(previewId);
        var file = input.files[0];
        if (!file) { preview.style.display = 'none'; return; }
        preview.innerHTML = '';
        var reader = new FileReader();
        reader.onload = function(e) {
            var div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = '<img src="' + e.target.result + '"><button type="button" class="preview-remove" onclick="this.parentElement.remove();document.getElementById(\'featured_image\').value=\'\';"><i class="fas fa-times"></i></button>';
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
        preview.style.display = 'grid';
    }
</script>
@endpush
@endsection
