@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Contact Messages</h1>
        <p class="page-subtitle">Messages submitted through the contact form.</p>
    </div>
</div>

<div class="card">
    @if(!empty($messages) && $messages->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr style="{{ !$message->is_read ? 'background:rgba(199,166,255,0.04);' : '' }}">
                            <td>
                                @if($message->is_read)
                                    <span class="badge badge-gray"><i class="fas fa-envelope-open"></i> Read</span>
                                @else
                                    <span class="badge badge-red"><i class="fas fa-circle" style="font-size:.5rem;"></i> Unread</span>
                                @endif
                            </td>
                            <td style="font-weight:{{ $message->is_read ? '400' : '600' }};">{{ $message->name }}</td>
                            <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                            <td style="max-width:250px;font-weight:{{ $message->is_read ? '400' : '600' }};">{{ $message->subject }}</td>
                            <td>{{ $message->created_at?->format('M d, Y') }}</td>
                            <td>
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <a href="{{ route('admin.contact.show', $message) }}" class="btn-icon" title="View"><i class="fas fa-eye"></i></a>
                                    @if(!$message->is_read)
                                        <form method="POST" action="{{ route('admin.contact.markRead', $message) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-icon" title="Mark as Read"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.contact.destroy', $message) }}" onsubmit="return confirm('Delete this message?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($messages, 'links'))
            <div style="margin-top:1.5rem;display:flex;justify-content:center;">
                {{ $messages->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-envelope"></i>
            <p>No contact messages yet.</p>
        </div>
    @endif
</div>
@endsection
