<!-- ============================================
     NAVBAR (PIHAK EKSTERNAL / USER PUBLIK)
============================================ -->
<nav class="navbar navbar-expand-lg navbar-hw" id="mainNav">
    <div class="container">
        <a class="hw-logo d-flex align-items-center gap-2" href="{{ route('user.home') }}">
            <span class="hw-logo-mark"><img src="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}" alt="Logo SMPN 2 Purwakarta"></span>
            <div>
                <span class="d-block fw-bold font-display" style="line-height: 1.1; font-size: 1.15rem;">SIPESAN</span>
                <span class="brand-badge-sub">SMPN 2 PURWAKARTA</span>
            </div>
        </a>
        
        <div class="d-flex align-items-center gap-2">
            <button class="theme-toggle-btn d-lg-none" type="button" data-theme-toggle aria-label="Ganti ke tema gelap" title="Ganti ke tema gelap">
                <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navMenu">
            <!-- Nav Menu: Beranda, Saran, Cek Status -->
            <ul class="navbar-nav nav-hw mx-auto mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active-link' : '' }}" href="{{ route('user.home') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.saran.create') ? 'active-link' : '' }}" href="{{ route('user.saran.create') }}">
                        Saran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.saran.status') ? 'active-link' : '' }}" href="{{ route('user.saran.status') }}">
                        Cek Status
                    </a>
                </li>
            </ul>

            <!-- Login khusus petugas admin Humas -->
            <div class="d-flex align-items-center mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-nav-admin rounded-pill px-3 py-1 font-display fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Admin
                </a>
                <button class="theme-toggle-btn d-none d-lg-inline-flex ms-2" type="button" data-theme-toggle aria-label="Ganti ke tema gelap" title="Ganti ke tema gelap">
                    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</nav>
