@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Site Settings</h1>
        <p class="page-subtitle">Configure your portfolio site's content and social links.</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-header" style="margin-bottom:1.5rem;">
            <h2 class="card-title"><i class="fas fa-globe" style="color:var(--accent);margin-right:.5rem;"></i> General</h2>
        </div>

        <div class="form-group">
            <label class="form-label" for="site_title">Site Title <span class="req">*</span></label>
            <input type="text" name="site_title" id="site_title" class="form-control" value="{{ old('site_title', $settings->site_title ?? '') }}" required>
            @error('site_title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="site_description">Site Description</label>
            <textarea name="site_description" id="site_description" class="form-control" rows="2">{{ old('site_description', $settings->site_description ?? '') }}</textarea>
            <div class="form-help">Used for SEO meta description.</div>
            @error('site_description') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="card-header" style="margin:2rem 0 1.5rem;">
            <h2 class="card-title"><i class="fas fa-home" style="color:var(--accent);margin-right:.5rem;"></i> Hero Section</h2>
        </div>

        <div class="form-group">
            <label class="form-label" for="hero_title">Hero Title</label>
            <input type="text" name="hero_title" id="hero_title" class="form-control" value="{{ old('hero_title', $settings->hero_title ?? '') }}" placeholder="e.g. Creative Developer & Researcher">
            @error('hero_title') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="hero_subtitle">Hero Subtitle</label>
            <textarea name="hero_subtitle" id="hero_subtitle" class="form-control" rows="2">{{ old('hero_subtitle', $settings->hero_subtitle ?? '') }}</textarea>
            @error('hero_subtitle') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="card-header" style="margin:2rem 0 1.5rem;">
            <h2 class="card-title"><i class="fas fa-user" style="color:var(--accent);margin-right:.5rem;"></i> About</h2>
        </div>

        <div class="form-group">
            <label class="form-label" for="about_text">About Text</label>
            <textarea name="about_text" id="about_text" class="form-control" rows="6">{{ old('about_text', $settings->about_text ?? '') }}</textarea>
            <div class="form-help">Supports plain text. Line breaks are preserved.</div>
            @error('about_text') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div class="card-header" style="margin:2rem 0 1.5rem;">
            <h2 class="card-title"><i class="fas fa-share-alt" style="color:var(--accent);margin-right:.5rem;"></i> Social Links</h2>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="social_github"><i class="fab fa-github" style="margin-right:.4rem;"></i> GitHub URL</label>
                <input type="text" name="social_github" id="social_github" class="form-control" value="{{ old('social_github', $settings->social_github ?? '') }}" placeholder="https://github.com/username">
                @error('social_github') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="social_youtube"><i class="fab fa-youtube" style="margin-right:.4rem;"></i> YouTube URL</label>
                <input type="text" name="social_youtube" id="social_youtube" class="form-control" value="{{ old('social_youtube', $settings->social_youtube ?? '') }}" placeholder="https://youtube.com/@channel">
                @error('social_youtube') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="social_instagram"><i class="fab fa-instagram" style="margin-right:.4rem;"></i> Instagram URL</label>
                <input type="text" name="social_instagram" id="social_instagram" class="form-control" value="{{ old('social_instagram', $settings->social_instagram ?? '') }}" placeholder="https://instagram.com/username">
                @error('social_instagram') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="social_email"><i class="fas fa-envelope" style="margin-right:.4rem;"></i> Contact Email</label>
                <input type="email" name="social_email" id="social_email" class="form-control" value="{{ old('social_email', $settings->social_email ?? '') }}" placeholder="contact@example.com">
                @error('social_email') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
        </div>

        <div class="card-header" style="margin:2rem 0 1.5rem;">
            <h2 class="card-title"><i class="fas fa-file-signature" style="color:var(--accent);margin-right:.5rem;"></i> Footer</h2>
        </div>

        <div class="form-group">
            <label class="form-label" for="footer_text">Footer Text</label>
            <textarea name="footer_text" id="footer_text" class="form-control" rows="2">{{ old('footer_text', $settings->footer_text ?? '') }}</textarea>
            <div class="form-help">Copyright or footer notice text.</div>
            @error('footer_text') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
        </div>

        <div style="display:flex;gap:.75rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
        </div>
    </form>
</div>
@endsection
