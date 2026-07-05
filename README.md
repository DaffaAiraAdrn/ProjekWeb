# DF_137 — Dynamic Portfolio Website

A fully dynamic, full-stack portfolio website with a custom CMS backend. Built with Laravel 11, MySQL, Three.js, GSAP, and Lenis.

## ✨ Features

### Public Website
- **Home** — Immersive hero with Three.js 3D particle field, POV camera rig, floating geometric shapes, scroll-driven animations
- **About** — Animated timeline, 3D rotating profile card, circular skill progress indicators, animated stat counters
- **Portfolio** — Filterable grid (All / 3D / ML / Programming) with 3D card tilt effects, GSAP stagger animations
- **Portfolio Detail** — Parallax hero, image gallery with lightbox, next/prev navigation
- **Blog** — Magazine-style layout with featured post hero
- **Blog Detail** — Reading progress bar, styled typography, tags
- **Reports** — Academic report display (Abstract, Introduction, Methodology, Results, Conclusion, References)
- **Contact** — AJAX form with glassmorphism design, saves to database

### Admin CMS (Secret URL)
- **Hidden Login** — No visible login button. Access via secret URL (default: `/vault-access`)
- **Dashboard** — Stats overview, recent activity, quick actions
- **Portfolio CRUD** — Full create/read/update/delete with image uploads
- **Blog CRUD** — Full blog post management with rich text editor (Quill)
- **Reports CRUD** — Multi-field report creation with rich text editors, file attachments (PDF/DOCX/images)
- **Media Gallery** — Centralized file management with drag-and-drop upload
- **Settings** — Site-wide settings management (hero text, social links, footer, etc.)
- **Messages** — Contact form submissions viewer with read/unread status

## 🎨 Design System

- **Theme**: Dark, modern, sleek
- **Colors**: Deep purples & reds
  - Backgrounds: `#150B22`, `#1C0D2A`
  - Gradients: `#2b0057`, `#4a0149`, `#5b001f`
  - Accent: `#C7A6FF`
  - Text: `#F5F3FF`
- **Font**: Montserrat (400, 600, 700)
- **Effects**: Glassmorphism, 3D parallax, particle systems, scroll-driven animations, custom cursor, page loader

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Database | MySQL 8.x |
| Frontend | HTML5, CSS3, Vanilla JS (ES6+) |
| 3D Graphics | Three.js (via CDN) |
| Animations | GSAP + ScrollTrigger (via CDN) |
| Smooth Scroll | Lenis (via CDN) |
| Rich Text Editor | Quill (via CDN) |
| Icons | Font Awesome (via CDN) |

## 📦 Installation

### Prerequisites
- PHP 8.2+
- MySQL 8.x
- Composer
- A web server (Apache/Nginx) — shared hosting (cPanel) compatible

### Steps

1. **Clone or upload the project**
   ```bash
   git clone <your-repo-url> portfolio
   cd portfolio
   ```

2. **Install PHP dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Edit `.env` with your database credentials:
   ```env
   DB_DATABASE=your_db_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password
   ```

4. **Run migrations and seed**
   ```bash
   php artisan migrate --seed
   ```
   Or import `database/schema.sql` directly via phpMyAdmin for shared hosting.

5. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

6. **Optimize for production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## 🔐 Admin Access

- **Login URL**: `https://yourdomain.com/vault-access` (configurable via `ADMIN_SECRET_ROUTE` in `.env`)
- **Default credentials**:
  - Email: `admin@df137.dev`
  - Password: `ChangeMe123!`
  
  ⚠️ **Change these immediately after first login!**

## 🚀 Deployment (GitHub Actions → FTP → Hostinger)

### Setup

1. Push your code to GitHub (main or master branch)

2. Add GitHub Secrets (Settings → Secrets and variables → Actions):
   - `FTP_SERVER` — Your Hostinger FTP hostname
   - `FTP_USERNAME` — Your FTP username
   - `FTP_PASSWORD` — Your FTP password

3. Every `git push` to main/master triggers automatic deployment via `.github/workflows/deploy.yml`

### Shared Hosting (.htaccess)

The `public/.htaccess` file handles:
- URL rewriting for Laravel routes
- Security headers (X-Content-Type-Options, X-Frame-Options, etc.)
- Gzip compression
- Browser caching

For shared hosting where the domain root must point to `/public`, either:
- Set your subdomain document root to `/public`
- Or use the included `.htaccess` in the project root to rewrite to `/public`

## 📁 Project Structure

```
portfolio/
├── .github/workflows/deploy.yml    # GitHub Actions FTP deployment
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Admin CRUD controllers
│   │   │   ├── AdminAuthController.php
│   │   │   ├── ContactController.php
│   │   │   └── PageController.php  # Public pages
│   │   └── Middleware/AdminAuth.php
│   └── Models/                     # Eloquent models
├── bootstrap/app.php               # Laravel 11 bootstrap
├── config/                         # Configuration files
├── database/
│   ├── migrations/                 # Database migrations
│   ├── seeders/DatabaseSeeder.php  # Seed data
│   └── schema.sql                  # Raw SQL for manual import
├── public/
│   ├── css/                        # style.css, effects.css, admin.css
│   ├── js/                         # main.js, three-scene.js, admin.js
│   ├── uploads/                    # User uploaded files
│   ├── .htaccess
│   └── index.php
├── resources/views/
│   ├── layouts/                    # app.blade.php, admin.blade.php
│   ├── pages/                      # Public page views
│   ├── admin/                      # Admin panel views
│   └── auth/login.blade.php
├── routes/web.php                  # All routes
├── .env.example
├── composer.json
└── README.md
```

## 📝 License

© 2026 Daffa Aira Adrin (DF_137). All rights reserved.
