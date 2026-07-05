@extends('layouts.admin')

@section('title', 'Edit Portfolio Item')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit: {{ $item->title }}</h1>
        <p class="page-subtitle">Update this portfolio project.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
        <a href="{{ route('admin.portfolio.show', $item) }}" class="btn btn-outline"><i class="fas fa-eye"></i> View</a>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.portfolio.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="title">Title <span class="req">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $item->title) }}" required>
            @error('title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="category">Category <span class="req">*</span></label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select a category…</option>
                    <option value="3D" {{ old('category', $item->category) === '3D' ? 'selected' : '' }}>3D</option>
                    <option value="ML" {{ old('category', $item->category) === 'ML' ? 'selected' : '' }}>ML</option>
                    <option value="Programming" {{ old('category', $item->category) === 'Programming' ? 'selected' : '' }}>Programming</option>
                </select>
                @error('category') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="order">Display Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $item->order ?? 0) }}" min="0">
                <div class="form-help">Lower numbers appear first.</div>
                @error('order') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Short Description <span class="req">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $item->description) }}</textarea>
            @error('description') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content <span class="req">*</span></label>
            <div id="editor-content"></div>
            <input type="hidden" name="content" id="content-input" value="{{ old('content', $item->content) }}">
            @error('content') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Thumbnail</label>
            @if(!empty($item->thumbnail))
                <div class="preview-grid" style="display:grid;">
                    <div class="preview-item">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Thumbnail">
                    </div>
                </div>
            @else
                <p class="form-help">No thumbnail set.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Replace Thumbnail</label>
            <div class="upload-zone" onclick="document.getElementById('thumbnail').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Click to upload a new thumbnail</p>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" onchange="previewSingle(this, 'thumb-preview')">
            </div>
            <div id="thumb-preview" class="preview-grid" style="display:none;"></div>
            @error('thumbnail') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Current Images</label>
            @if(!empty($item->images) && count($item->images) > 0)
                <div class="preview-grid" style="display:grid;">
                    @foreach($item->images as $image)
                        <div class="preview-item" id="existing-img-{{ $image->id ?? $loop->index }}">
                            <img src="{{ asset('storage/' . ($image->path ?? $image)) }}" alt="Project image">
                            <button type="button" class="preview-remove" onclick="deleteImage({{ $image->id ?? 'null' }}, this)" style="background:rgba(220,38,38,0.8);"><i class="fas fa-times"></i></button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="form-help">No additional images uploaded.</p>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label">Add More Images</label>
            <div class="upload-zone" onclick="document.getElementById('images').click()">
                <i class="fas fa-images"></i>
                <p>Click to upload additional images</p>
                <input type="file" name="images[]" id="images" accept="image/*" multiple onchange="previewMultiple(this, 'images-preview')">
            </div>
            <div id="images-preview" class="preview-grid" style="display:none;"></div>
            @error('images') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured', $item->featured) ? 'checked' : '' }}>
                <label for="featured">Feature this item on the homepage</label>
            </div>
            @error('featured') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
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

    function deleteImage(id, btn) {
        if (!confirm('Delete this image?')) return;
        if (id) {
            fetch('{{ url("/admin/portfolio/images") }}/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(function() { btn.parentElement.remove(); });
        } else {
            btn.parentElement.remove();
        }
    }
</script>
@endpush
@endsection
