<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/portfolio', [PageController::class, 'portfolioIndex'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PageController::class, 'portfolioShow'])->name('portfolio.show');
Route::get('/blog', [PageController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/reports', [PageController::class, 'reportsIndex'])->name('reports.index');
Route::get('/reports/{slug}', [PageController::class, 'reportsShow'])->name('reports.show');
Route::get('/contact', function () {
    $settings = \App\Models\SiteSetting::getAll();
    return view('pages.contact', compact('settings'));
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (secret login URL)
|--------------------------------------------------------------------------
*/
$secretRoute = env('ADMIN_SECRET_ROUTE', 'vault-access');

Route::get("/{$secretRoute}", [AdminAuthController::class, 'login'])
    ->name('admin.login');
Route::post("/{$secretRoute}", [AdminAuthController::class, 'authenticate'])
    ->name('admin.authenticate');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Portfolio Resource
    Route::resource('portfolio', PortfolioController::class);

    // Blog Resource
    Route::resource('blog', BlogPostController::class);

    // Reports Resource
    Route::resource('reports', ReportController::class);

    // Media (index, store, destroy only)
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

    // Contact Submissions
    Route::get('contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::get('contact/{contact}', [AdminContactController::class, 'show'])->name('contact.show');
    Route::delete('contact/{contact}', [AdminContactController::class, 'destroy'])->name('contact.destroy');
});
