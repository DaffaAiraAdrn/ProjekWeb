@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Media Library</h1>
        <p class="page-subtitle">Upload and manage your media files.</p>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><h2 class="card-title">Upload Files</h2></div>
    <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="media-upload-form">
        @csrf
        <div class="upload-zone" id="drop-zone" onclick="document.getElementById('media-files').click()">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Drag and drop files here or click to browse<br>Images, PDF, DOCX up to 20MB</p>
            <input type="file" name="files[]" id="media-files" accept="image/*,.pdf,.docx" multiple onchange="previewMediaFiles(this)">
        </div>
        <div id="media-preview" style="margin-top:1rem;"></div>
        <div id="upload-btn" style="margin-top:1rem;display:none;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Files</button>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">All Files ({{ $media->total() ?? $media->count() ?? 0 }})</h2>
    </div>
    @if(!empty($media) && $media->count() > 0)
        <div class="media-grid">
            @foreach($media as $file)
                <div class="media-card" id="media-{{ $file->id ?? $loop->index }}">
                    <div class="media-thumb">
                        @if(str_starts_with($file->mime_type ?? $file->file_type ?? '', 'image/'))
                            <img src="{{ asset('storage/' . ($file->path ?? $file->file_path)) }}" alt="{{ $file->name ?? $file->file_name }}">
                        @else
                            <i class="fas {{ getFileIcon($file->mime_type ?? $file->file_type ?? '') }}"></i>
                        @endif
                    </div>
                    <div class="media-info">
                        <div class="media-name">{{ $file->name ?? $file->file_name }}</div>
                        <div class="media-meta">
                            <span>{{ strtoupper(pathinfo($file->name ?? $file->file_name ?? '', PATHINFO_EXTENSION)) }}</span>
                            <span>{{ formatFileSize($file->size ?? $file->file_size ?? 0) }}</span>
                        </div>
                    </div>
                    <div style="padding:0 .75rem .75rem;display:flex;gap:.4rem;">
                        <a href="{{ asset('storage/' . ($file->path ?? $file->file_path)) }}" target="_blank" class="btn-icon btn-sm" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ asset('storage/' . ($file->path ?? $file->file_path)) }}" download class="btn-icon btn-sm" title="Download"><i class="fas fa-download"></i></a>
                        <form method="POST" action="{{ route('admin.media.destroy', $file->id ?? $file) }}" onsubmit="return confirm('Delete this file?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-sm danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        @if(method_exists($media, 'links'))
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">
                {{ $media->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-photo-video"></i>
            <p>No media files yet. Upload your first file above.</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    var dropZone = document.getElementById('drop-zone');
    dropZone.addEventListener('dragover', function(e) { e.preventDefault(); this.classList.add('dragover'); });
    dropZone.addEventListener('dragleave', function(e) { e.preventDefault(); this.classList.remove('dragover'); });
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        var input = document.getElementById('media-files');
        input.files = e.dataTransfer.files;
        previewMediaFiles(input);
    });

    function previewMediaFiles(input) {
        var preview = document.getElementById('media-preview');
        var uploadBtn = document.getElementById('upload-btn');
        preview.innerHTML = '';
        var icons = { pdf: 'fa-file-pdf', docx: 'fa-file-word', png: 'fa-file-image', jpg: 'fa-file-image', jpeg: 'fa-file-image', gif: 'fa-file-image', webp: 'fa-file-image' };
        Array.from(input.files).forEach(function(file, i) {
            var ext = file.name.split('.').pop().toLowerCase();
            var isImage = file.type.startsWith('image/');
            var div = document.createElement('div');
            div.className = 'preview-file';
            if (isImage) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    div.innerHTML = '<img src="' + e.target.result + '" style="width:40px;height:40px;border-radius:8px;object-fit:cover;"><div class="file-info"><div class="file-name">' + file.name + '</div><div class="file-size">' + formatSize(file.size) + '</div></div><button type="button" class="btn-icon danger" onclick="this.parentElement.remove();checkUploadBtn();"><i class="fas fa-times"></i></button>';
                };
                reader.readAsDataURL(file);
            } else {
                var icon = icons[ext] || 'fa-file';
                div.innerHTML = '<i class="fas ' + icon + '"></i><div class="file-info"><div class="file-name">' + file.name + '</div><div class="file-size">' + formatSize(file.size) + '</div></div><button type="button" class="btn-icon danger" onclick="this.parentElement.remove();checkUploadBtn();"><i class="fas fa-times"></i></button>';
            }
            preview.appendChild(div);
        });
        uploadBtn.style.display = input.files.length > 0 ? 'block' : 'none';
    }
    function checkUploadBtn() {
        var preview = document.getElementById('media-preview');
        document.getElementById('upload-btn').style.display = preview.children.length > 0 ? 'block' : 'none';
    }
    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes/1024).toFixed(1) + ' KB';
        return (bytes/1048576).toFixed(1) + ' MB';
    }
</script>
@endpush

@php
    function getFileIcon($mime) {
        $mime = strtolower($mime);
        if (str_contains($mime, 'pdf')) return 'fa-file-pdf';
        if (str_contains($mime, 'doc') || str_contains($mime, 'word')) return 'fa-file-word';
        if (str_contains($mime, 'image')) return 'fa-file-image';
        if (str_contains($mime, 'video')) return 'fa-file-video';
        if (str_contains($mime, 'audio')) return 'fa-file-audio';
        if (str_contains($mime, 'zip') || str_contains($mime, 'compressed')) return 'fa-file-archive';
        return 'fa-file';
    }
    function formatFileSize($bytes) {
        $bytes = (int) $bytes;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
@endphp
@endsection
