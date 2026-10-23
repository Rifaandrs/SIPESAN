<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard') - SIPESAN</title>
  <script>
    try {
      document.documentElement.dataset.theme = localStorage.getItem('sipesan-theme') === 'dark' ? 'dark' : 'light';
    } catch (error) {
      console.warn('Preferensi tema tidak dapat dibaca.', error);
    }
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}">

  <!-- Local Third-Party Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

  @stack('styles')
</head>

<body>

  @if (session('show_preloader'))
    <div id="preloader" aria-hidden="true">
      <div class="preload-ring"><i class="bi bi-mortarboard-fill preload-heart"></i></div>
      <div class="preload-text">SIPESAN SMPN 2 PURWAKARTA&hellip;</div>
    </div>
  @endif

  <!-- Sidebar Component -->
  @include('layouts.partials.sidebar')

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">

    <!-- Top Navbar Component -->
    @include('layouts.partials.navbar')

    <!-- Dynamic Content Area -->
    <main class="content-area">
      @yield('content')
    </main>

    <!-- Footer Component -->
    @include('layouts.partials.footer')

  </div>

  <div class="modal fade" id="profilePhotoModal" tabindex="-1" aria-labelledby="profilePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content profile-photo-modal">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="profilePhotoModalLabel">Foto Profil</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body pt-0 text-center">
          <img src="" alt="Foto profil ukuran penuh" id="fullProfilePhoto" class="full-profile-photo">
        </div>
      </div>
    </div>
  </div>

  <!-- Local Third-Party Libraries Script dependencies -->
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/preloader.js') }}"></script>
  <script src="{{ asset('assets/js/profile-photo.js') }}"></script>
  <!-- Local dashboard interactions controller -->
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>

  @stack('scripts')
</body>

</html>
