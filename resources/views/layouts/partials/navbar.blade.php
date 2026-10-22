<!-- START: Top Navbar Component -->
<header class="navbar-custom d-print-none">
  <div class="navbar-left">
    <!-- Desktop sidebar toggle (visible on large screens only) -->
    <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
      id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
      <i class="bi bi-chevron-bar-left"></i>
    </button>
    <!-- Mobile sidebar toggle -->
    <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
      <i class="bi bi-list"></i>
    </button>

    <!-- Quick Actions Dropdown -->
    <div class="dropdown ms-2">
      <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
        id="quick-actions-dropdown">
        <i class="bi bi-plus-lg"></i>
        <span>Create</span>
      </button>
      <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
        <li class="dropdown-header">Quick Action Shortcuts</li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-plus"></i> New Transaction</a></li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-person-plus"></i> New User</a></li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam"></i> New Item</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> System Settings</a></li>
      </ul>
    </div>
  </div>

  <!-- Mid navbar: search pill -->
  <div class="navbar-search-wrapper">
    <input type="text" class="navbar-search-input" placeholder="Cari di SIPESAN..." id="main-search">
    <button class="navbar-search-btn" aria-label="Search">
      <i class="bi bi-search"></i>
    </button>
  </div>

  <!-- Right actions -->
  <div class="navbar-actions">
    <!-- Fullscreen Toggle -->
    <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
      <i class="bi bi-arrows-fullscreen"></i>
    </button>

    <!-- Profile Dropdown -->
    <div class="dropdown ms-2">
      <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false" id="profile-dropdown">
        <img src="{{ asset('assets/images/avatar.png') }}" alt="Profile Image" class="navbar-profile-img">
        <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->name ?? 'Administrator' }}</span>
        <i class="bi bi-chevron-down navbar-profile-caret"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
        <li class="dropdown-header pb-2">
          <div class="fw-bold text-dark text-truncate">{{ Auth::user()->name ?? 'Administrator' }}</div>
          <div class="small text-muted mt-1">Peran: <span class="badge bg-danger">{{ (Auth::user()->role ?? '') === 'admin' ? 'Wakasek Humas' : 'Pihak Eksternal' }}</span></div>
        </li>
        <li>
          <hr class="dropdown-divider my-1">
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
