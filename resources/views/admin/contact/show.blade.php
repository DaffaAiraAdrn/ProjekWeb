@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Contact Message</h1>
        <p class="page-subtitle">{{ $message->subject }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.contact.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Messages</a>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    <div class="detail-row">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            @if($message->is_read)
                <span class="badge badge-gray"><i class="fas fa-envelope-open"></i> Read</span>
            @else
                <span class="badge badge-red"><i class="fas fa-circle" style="font-size:.5rem;"></i> Unread</span>
            @endif
        </div>
    </div>
    <div class="detail-row">
        <div class="detail-label">From</div>
        <div class="detail-value">
            <strong>{{ $message->name }}</strong>
            &nbsp;·&nbsp; <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
        </div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Subject</div>
        <div class="detail-value">{{ $message->subject }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Received</div>
        <div class="detail-value">{{ $message->created_at?->format('M d, Y \a\t H:i') }}</div>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><h2 class="card-title">Message</h2></div>
    <div class="detail-content" style="white-space:pre-wrap;">{{ $message->message }}</div>
</div>

@if(!$message->is_read)
    <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-header"><h2 class="card-title">Reply</h2></div>
        <form action="{{ route('admin.contact.reply', $message) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="reply_body">Reply Message</label>
                <textarea name="reply_body" id="reply_body" class="form-control" rows="6" placeholder="Type your reply here..." required>{{ old('reply_body') }}</textarea>
                @error('reply_body') <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send Reply</button>
        </form>
    </div>
@endif

<div style="display:flex;gap:.75rem;flex-wrap:wrap;">
    @if(!$message->is_read)
        <form method="POST" action="{{ route('admin.contact.markRead', $message) }}" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-outline"><i class="fas fa-check"></i> Mark as Read</button>
        </form>
    @endif
    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-accent"><i class="fas fa-reply"></i> Reply via Email</a>
    <form method="POST" action="{{ route('admin.contact.destroy', $message) }}" onsubmit="return confirm('Delete this message permanently?');" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Message</button>
    </form>
</div>
@endsection
