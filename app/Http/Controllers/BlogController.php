<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $reports = [
        [
            'id' => 1,
            'title' => 'Practical Report 1: Setup and Configuration',
            'date' => 'October 10, 2025',
            'excerpt' => 'This report covers the initial setup and configuration of the development environment, including Laravel installation.',
            'content' => '<p>In this first practical report, I detail the steps taken to configure my development machine for the upcoming project. This includes setting up <strong>XAMPP</strong>, configuring <strong>Composer</strong>, and verifying the PHP versions. Additionally, I set up a new Laravel project using the command line interface and explored the default directory structure.</p><p>We also implemented a basic routing mechanism to serve a static landing page. The process involved modifying the <code>routes/web.php</code> file and creating a corresponding blade template in <code>resources/views</code>.</p>'
        ],
        [
            'id' => 2,
            'title' => 'Practical Report 2: Database Migration',
            'date' => 'October 17, 2025',
            'excerpt' => 'An overview of database design, creating migrations, and running seeders in Laravel.',
            'content' => '<p>This practical session focused on interacting with a MySQL database using Laravel\'s robust Eloquent ORM. First, we designed the schema for the application, consisting of Users, Posts, and Comments. Next, we translated this schema into <strong>Laravel Migrations</strong>.</p><p>We executed <code>php artisan migrate</code> to generate the tables and subsequently created seeders to populate the database with dummy data for testing purposes. We encountered an issue with foreign key constraints, which was resolved by ensuring the referenced tables were migrated first.</p>'
        ],
        [
            'id' => 3,
            'title' => 'Practical Report 3: Frontend Integration',
            'date' => 'October 24, 2025',
            'excerpt' => 'Integrating Bootstrap 5 and custom CSS into the Laravel Blade templating engine.',
            'content' => '<p>During this practical, the focus shifted to the frontend presentation. The static HTML templates previously designed were integrated into the Laravel project. We created a master layout file (<code>app.blade.php</code>) utilizing the <code>@yield</code> and <code>@section</code> directives.</p><p>Bootstrap 5 was included via local asset files, placed in the <code>public</code> directory. We dynamically linked CSS and JS using Laravel\'s <code>asset()</code> helper function. The result is a fully functional, dynamic application sharing a single consistent layout header and footer.</p>'
        ]
    ];

    public function index()
    {
        return view('pages.blog', ['reports' => $this->reports]);
    }

    public function show($id)
    {
        $report = collect($this->reports)->firstWhere('id', (int) $id);

        if (!$report) {
            abort(404);
        }

        return view('pages.blog-show', ['report' => $report]);
    }
}
