<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - SIPESAN</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}">
    
    <!-- Local Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card">
            
            <a href="{{ route('user.home') }}" class="login-brand text-decoration-none">
                <img src="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}" alt="Logo SMPN 2 Purwakarta">
                <span>SIPESAN</span>
            </a>
            
            <p class="login-subtitle">Registrasi Akun Pihak Eksternal (SMPN 2 Purwakarta)</p>

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger p-2 mb-3 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Register Form -->
            <form action="{{ route('register') }}" method="POST" id="registerForm" class="needs-validation" novalidate>
                @csrf
                
                <!-- Name Input Group -->
                <div class="login-form-group">
                    <label for="name" class="login-form-label">Nama Lengkap</label>
                    <div class="login-input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" id="name" class="login-input" 
                               value="{{ old('name') }}" placeholder="Contoh: Rifa Andriansyah" required autofocus>
                    </div>
                </div>

                <!-- Email Input Group -->
                <div class="login-form-group">
                    <label for="email" class="login-form-label">Alamat Email</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="login-input" 
                               value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>
                </div>
                
                <!-- Password Input Group -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Kata Sandi</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="login-input" 
                               placeholder="Minimal 8 karakter" minlength="8" required>
                    </div>
                </div>

                <!-- Password Confirmation Input Group -->
                <div class="login-form-group">
                    <label for="password_confirmation" class="login-form-label">Konfirmasi Kata Sandi</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-check input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="login-input" 
                               placeholder="Ulangi kata sandi" required>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login mt-3" id="btn-submit">
                    <span>Daftar Akun</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
                
            </form>
            
            <!-- Footer Link -->
            <p class="login-footer-text mt-4 mb-0">
                Sudah memiliki akun? <a href="{{ route('login') }}" id="link-login" class="fw-semibold">Masuk di sini</a>
            </p>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth.js') }}"></script>
</body>
</html>
