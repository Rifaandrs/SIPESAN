<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - SIPESAN SMPN 2 Purwakarta</title>
    <meta name="description" content="SIPESAN - Sistem Pelayanan Saran Eksternal SMPN 2 Purwakarta">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{ asset('assets-user/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- User Template Style -->
    <link href="{{ asset('assets-user/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}">

    <style>
        .navbar-hw {
            position: sticky;
            top: 0;
            background: #ffffff !important;
            box-shadow: 0 2px 14px rgba(15, 23, 42, 0.08);
            padding: 12px 0;
            z-index: 1000;
        }
        .brand-badge-sub {
            font-size: 0.72rem;
            letter-spacing: 0.04em;
            display: block;
            color: #64748b;
            font-weight: 500;
        }
        .nav-link.active-link {
            color: var(--clr-primary) !important;
            font-weight: 700;
        }
        .btn-hw-primary {
            background-color: var(--clr-primary);
            color: #fff;
            padding: 0.65rem 1.4rem;
            border-radius: 999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
            border: none;
        }
        .btn-hw-primary:hover {
            background-color: var(--clr-primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -8px rgba(54, 103, 172, 0.4);
        }
        .btn-hw-outline {
            border: 2px solid var(--clr-primary);
            color: var(--clr-primary);
            padding: 0.6rem 1.3rem;
            border-radius: 999px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.25s ease;
            background: transparent;
        }
        .btn-hw-outline:hover {
            background-color: var(--clr-primary);
            color: #fff;
            transform: translateY(-2px);
        }
        .btn-nav-admin {
            border: 1.5px solid var(--clr-primary);
            color: var(--clr-primary);
            background: transparent;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .btn-nav-admin:hover {
            background-color: var(--clr-primary);
            color: #ffffff;
            border-color: var(--clr-primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(54, 103, 172, 0.25);
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- ============================================
         PRELOADER
    ============================================ -->
    <div id="preloader" aria-hidden="true">
        <div class="preload-ring"><i class="bi bi-mortarboard-fill preload-heart"></i></div>
        <div class="preload-text">SIPESAN SMPN 2 PURWAKARTA&hellip;</div>
    </div>

    <!-- Top Navbar Component (User) -->
    @include('layouts.partials.navbar_user')

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Component (User) -->
    @include('layouts.partials.footer_user')

    <!-- Scroll To Top -->
    <div id="scrollTop" role="button" aria-label="Scroll to top" tabindex="0">
        <svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="23"></circle><circle class="progress" cx="26" cy="26" r="23"></circle></svg>
        <i class="bi bi-arrow-up"></i>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('assets-user/bootstrap.bundle.min.js') }}"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Template Script -->
    <script src="{{ asset('assets-user/script.js') }}"></script>

    @stack('scripts')
</body>
</html>
