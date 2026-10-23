<!-- START: Top Navbar Component -->
<header class="navbar-custom d-print-none">

    <!-- Kiri: Toggle Sidebar -->
    <div class="navbar-left">
        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
            id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
            <i class="bi bi-chevron-bar-left"></i>
        </button>
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Kanan: Fullscreen + Profile -->
    <div class="navbar-actions">
        <button class="navbar-action-btn" type="button" data-theme-toggle aria-label="Ganti ke tema gelap" title="Ganti ke tema gelap">
            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
        </button>
        <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
            <i class="bi bi-arrows-fullscreen"></i>
        </button>

        <div class="dropdown ms-2">
            <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" id="profile-dropdown">
                <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('assets/images/default-avatar.jpg') }}"
                    alt="Profile Image" class="navbar-profile-img" data-profile-photo>
                <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->name ?? 'Administrator' }}</span>
                <i class="bi bi-chevron-down navbar-profile-caret"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
                <li class="dropdown-header pb-2">
                    <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
                </li>
                <li>
                    <a class="dropdown-item py-2" href="{{ route('admin.profile') }}">
                        <i class="bi bi-person-circle me-1"></i> Profil Saya
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start py-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar (Logout)
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</header>
<!-- END: Top Navbar Component -->
