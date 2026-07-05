<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\BlogPost;
use App\Models\Report;
use App\Models\ContactSubmission;
use App\Models\Media;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'portfolios' => Portfolio::count(),
            'blog_posts' => BlogPost::count(),
            'reports' => Report::count(),
            'contacts' => ContactSubmission::count(),
            'unread_contacts' => ContactSubmission::where('is_read', false)->count(),
            'media' => Media::count(),
            'featured_portfolios' => Portfolio::where('featured', true)->count(),
            'published_posts' => BlogPost::where('status', 'published')->count(),
        ];

        $recentContacts = ContactSubmission::latest()->take(5)->get();
        $recentPortfolios = Portfolio::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentPortfolios'));
    }
}
