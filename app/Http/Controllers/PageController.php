<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\BlogPost;
use App\Models\Report;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $settings = SiteSetting::getAll();
        $portfolios = Portfolio::where('featured', true)->orderBy('order')->take(6)->get();
        $latestPosts = BlogPost::published()->latest('published_at')->take(3)->get();
        $latestReports = Report::published()->latest('published_at')->take(3)->get();

        return view('pages.home', compact('settings', 'portfolios', 'latestPosts', 'latestReports'));
    }

    public function about()
    {
        $settings = SiteSetting::getAll();
        $portfolios = Portfolio::orderBy('order')->orderBy('id', 'desc')->get();

        return view('pages.about', compact('settings', 'portfolios'));
    }

    public function portfolioIndex()
    {
        $settings = SiteSetting::getAll();
        $portfolios = Portfolio::orderBy('order')->orderBy('id', 'desc')->paginate(12);

        return view('pages.portfolio', compact('settings', 'portfolios'));
    }

    public function portfolioShow(string $slug)
    {
        $settings = SiteSetting::getAll();
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();
        $related = Portfolio::where('category', $portfolio->category)
            ->where('id', '!=', $portfolio->id)
            ->take(3)->get();

        return view('pages.portfolio-detail', compact('settings', 'portfolio', 'related'));
    }

    public function blogIndex()
    {
        $settings = SiteSetting::getAll();
        $posts = BlogPost::published()->latest('published_at')->paginate(9);

        return view('pages.blog', compact('settings', 'posts'));
    }

    public function blogShow(string $slug)
    {
        $settings = SiteSetting::getAll();
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')->take(3)->get();

        return view('pages.blog-detail', compact('settings', 'post', 'related'));
    }

    public function reportsIndex()
    {
        $settings = SiteSetting::getAll();
        $reports = Report::published()->latest('published_at')->paginate(9);

        return view('pages.reports', compact('settings', 'reports'));
    }

    public function reportsShow(string $slug)
    {
        $settings = SiteSetting::getAll();
        $report = Report::published()->where('slug', $slug)->firstOrFail();

        return view('pages.reports-detail', compact('settings', 'report'));
    }
}
