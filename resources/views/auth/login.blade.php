<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — DF_137</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/effects.css') }}">

    <style>
        body { cursor: auto; }
        .form-input { cursor: text; }
        button { cursor: pointer; }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    <div class="canvas-bg-orbs">
        <div class="canvas-bg-orb"></div>
        <div class="canvas-bg-orb"></div>
    </div>
    <div class="noise-overlay"></div>

    <div class="login-page">
        <div class="login-card reveal-scale visible">
            <div class="login-logo">
                <span class="logo-bracket">[</span>DF_137<span class="logo-bracket">]</span>
            </div>
            <p class="login-subtitle">Admin Access Only</p>

            @if(session('error'))
                <div class="login-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="login-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>
