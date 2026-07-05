@extends('layouts.admin')

@section('title', 'New Portfolio Item')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Portfolio Item</h1>
        <p class="page-subtitle">Add a new project to your portfolio.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Neural Network Visualizer" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="category">Category <span class="req">*</span></label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select a category…</option>
                    <option value="3D" {{ old('category') === '3D' ? 'selected' : '' }}>3D</option>
                    <option value="ML" {{ old('category') === 'ML' ? 'selected' : '' }}>ML</option>
                    <option value="Programming" {{ old('category') === 'Programming' ? 'selected' : '' }}>Programming</option>
                </select>
                @error('category') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="order">Display Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}" min="0" placeholder="0">
                <div class="form-help">Lower numbers appear first.</div>
                @error('order') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Short Description <span class="req">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="A brief summary shown in the portfolio grid." required>{{ old('description') }}</textarea>
            @error('description') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content <span class="req">*</span></label>
            <div id="editor-content"></div>
            <input type="hidden" name="content" id="content-input" value="{{ old('content') }}">
            @error('content') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Thumbnail</label>
            <div class="upload-zone" onclick="document.getElementById('thumbnail').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload or drag and drop<br>PNG, JPG, WEBP up to 5MB</p>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewSingle(this, 'thumb-preview')">
            </div>
            <div id="thumb-preview" class="preview-grid" style="display:none;"></div>
            @error('thumbnail') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Project Images</label>
            <div class="upload-zone" onclick="document.getElementById('images').click()">
                <i class="fas fa-images"></i>
                <p>Click to upload multiple images<br>They will appear in a gallery</p>
                <input type="file" name="images[]" id="images" accept="image/*" multiple onchange="previewMultiple(this, 'images-preview')">
            </div>
            <div id="images-preview" class="preview-grid" style="display:none;"></div>
            @error('images') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                <label for="featured">Feature this item on the homepage</label>
            </div>
            @error('featured') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Item</button>
            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    var quillContent = new Quill('#editor-content', {
        theme: 'snow',
        modules: { toolbar: [['bold','italic','underline'],[{ 'header': [2,3,4,false] }],['code-block','blockquote'],['link'],['clean']] }
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
            div.innerHTML = '<img src="' + e.target.result + '"><button type="button" class="preview-remove" onclick="this.parentElement.remove();document.getElementById(\'thumbnail\').value=\'\';"><i class="fas fa-times"></i></button>';
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
        preview.style.display = 'grid';
    }

    function previewMultiple(input, previewId) {
        var preview = document.getElementById(previewId);
        preview.innerHTML = '';
        Array.from(input.files).forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = '<img src="' + e.target.result + '"><button type="button" class="preview-remove" onclick="this.parentElement.remove();"><i class="fas fa-times"></i></button>';
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
        preview.style.display = 'grid';
    }
</script>
@endpush
@endsection
