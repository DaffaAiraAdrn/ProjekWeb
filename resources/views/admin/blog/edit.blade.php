@extends('layouts.admin')

@section('title', 'Edit: ' . $post->title)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Blog Post</h1>
        <p class="page-subtitle">{{ $post->title }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="excerpt">Excerpt</label>
            <textarea name="excerpt" id="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content <span class="req">*</span></label>
            <div id="editor-content"></div>
            <input type="hidden" name="content" id="content-input" value="{{ old('content', $post->content) }}">
            @error('content') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Featured Image</label>
            @if(!empty($post->featured_image))
                <div class="preview-grid" style="display:grid;">
                    <div class="preview-item">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured image">
                    </div>
                </div>
            @else
                <p class="form-help">No featured image set.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Replace Featured Image</label>
            <div class="upload-zone" onclick="document.getElementById('featured_image').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload a new featured image</p>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" onchange="previewSingle(this, 'img-preview')">
            </div>
            <div id="img-preview" class="preview-grid" style="display:none;"></div>
            @error('featured_image') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="tags">Tags</label>
                <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', $post->tags) }}" placeholder="comma, separated, tags">
                <div class="form-help">Separate tags with commas.</div>
                @error('tags') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status <span class="req">*</span></label>
                <select name="status" id="status" class="form-control" required>
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="published_at">Publish Date</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
            @error('published_at') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
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
