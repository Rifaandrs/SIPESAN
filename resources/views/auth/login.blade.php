<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIPESAN</title>
    
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
            
            <p class="login-subtitle">Login administrator SIPESAN SMPN 2 Purwakarta</p>
            <p class="text-center small text-muted mb-4">Pengiriman kritik dan saran untuk sekolah dapat dilakukan tanpa login.</p>

            @if(session('success'))
                <div class="alert-custom alert-custom-success mb-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill alert-custom-icon text-success"></i>
                    <div class="alert-custom-content">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Alert Merah Jika Username / Kata Sandi Tidak Sesuai --}}
            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="alert-custom alert-custom-danger mb-4 shadow-sm" role="alert" style="background-color: #fef2f2; border: 1.5px solid #f87171; color: #991b1b; border-radius: 12px; padding: 12px 14px; display: flex; align-items: flex-start; gap: 10px;">
                    <i class="bi bi-exclamation-octagon-fill text-danger flex-shrink-0" style="font-size: 1.3rem; margin-top: 1px;"></i>
                    <div style="flex-grow: 1;">
                        <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px;">Gagal Masuk:</strong>
                        <span style="font-size: 0.875rem;">
                            @if(session('error'))
                                {{ session('error') }}
                            @elseif($errors->has('password'))
                                {{ $errors->first('password') }}
                            @elseif($errors->has('username'))
                                {{ $errors->first('username') }}
                            @elseif($errors->has('email'))
                                {{ $errors->first('email') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </span>
                    </div>
                </div>
            @endif
            
            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                
                <!-- Username Input Group -->
                <div class="login-form-group">
                    <label for="username" class="login-form-label">Username Admin</label>
                    <div class="login-input-group {{ ($errors->has('username') || $errors->has('email') || (session('error') && !$errors->has('password'))) ? 'border-danger shake-animation' : '' }}" 
                         style="{{ ($errors->has('username') || $errors->has('email') || (session('error') && !$errors->has('password'))) ? 'border-color: #ef4444 !important;' : '' }}">
                        <i class="bi bi-person input-icon {{ ($errors->has('username') || $errors->has('email') || (session('error') && !$errors->has('password'))) ? 'text-danger' : '' }}"></i>
                        <input type="text" name="username" id="username" class="login-input" 
                               value="{{ old('username') ?? old('email') }}" placeholder="Masukkan username admin" 
                               required {{ !$errors->has('password') ? 'autofocus' : '' }} autocomplete="username">
                    </div>
                    @if($errors->has('username'))
                        <div class="text-danger mt-1 d-flex align-items-center" style="font-size: 0.8rem; font-weight: 500;">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first('username') }}
                        </div>
                    @elseif($errors->has('email'))
                        <div class="text-danger mt-1 d-flex align-items-center" style="font-size: 0.8rem; font-weight: 500;">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                
                <!-- Password Input Group -->
                <div class="login-form-group">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="login-form-label mb-0">Kata Sandi</label>
                        <span class="text-muted" style="font-size: 0.75rem;">Minimal 8 karakter</span>
                    </div>
                    <div class="login-input-group {{ $errors->has('password') ? 'border-danger shake-animation' : '' }}" 
                         style="{{ $errors->has('password') ? 'border-color: #ef4444 !important;' : '' }}">
                        <i class="bi bi-shield-lock input-icon {{ $errors->has('password') ? 'text-danger' : '' }}"></i>
                        <input type="password" name="password" id="password" class="login-input login-input-password" 
                               placeholder="Masukkan kata sandi" minlength="8" required 
                               {{ $errors->has('password') ? 'autofocus' : '' }} 
                               autocomplete="current-password">
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @if($errors->has('password'))
                        <div class="text-danger mt-1 d-flex align-items-center" style="font-size: 0.8rem; font-weight: 500;">
                            <i class="bi bi-x-circle-fill me-1"></i> {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                
                <!-- Options / Back Link -->
                <div class="login-options d-flex justify-content-end align-items-center mb-3">
                    <a href="{{ route('user.home') }}" class="forgot-password-link small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login" id="btn-submit">
                    <span>Masuk ke Panel Admin</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
                
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/auth.js') }}?v={{ filemtime(public_path('assets/js/auth.js')) }}"></script>
</body>
</html>
