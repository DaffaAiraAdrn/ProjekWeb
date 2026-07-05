<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query();

        if ($request->filled('filter') && $request->filter === 'unread') {
            $query->where('is_read', false);
        }

        $submissions = $query->latest()->paginate(15);

        return view('admin.contact.index', compact('submissions'));
    }

    public function show(ContactSubmission $contact)
    {
        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contact.show', compact('contact'));
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact submission deleted successfully.');
    }
}
