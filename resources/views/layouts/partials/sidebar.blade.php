<!-- ==========================================
     START: Sidebar Component - Wakasek Humas
     ========================================== -->
<div class="sidebar-wrapper d-print-none" id="sidebar">
  <!-- Brand Logo / Identity -->
  <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
    <img src="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}" alt="">
    <span>SIPESAN</span>
  </a>

  <!-- Navigation Menu Sesuai Desain Mockup Panel 5 -->
  <div class="flex-grow-1 overflow-y-auto">
    <!-- Group: Admin Menu -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Menu Utama</div>
      <ul class="sidebar-menu-list">
        <!-- 1. Dashboard -->
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" id="menu-dashboard" title="Dashboard">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <!-- 2. Saran -->
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.saran.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.saran*') ? 'active' : '' }}" id="menu-saran" title="Daftar Saran">
            <i class="bi bi-chat-left-text-fill"></i>
            <span>Saran Masuk</span>
          </a>
        </li>

        <!-- 3. Kategori -->
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.categories.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" id="menu-kategori" title="Kategori Saran">
            <i class="bi bi-tags-fill"></i>
            <span>Kategori</span>
          </a>
        </li>

        <!-- 4. Pengguna -->
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.users') }}" class="sidebar-menu-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" id="menu-pengguna" title="Manajemen Pengguna">
            <i class="bi bi-people-fill"></i>
            <span>Pengguna</span>
          </a>
        </li>

        <!-- 5. Laporan -->
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.laporan.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}" id="menu-laporan" title="Laporan & Rekap">
            <i class="bi bi-file-earmark-bar-graph-fill"></i>
            <span>Laporan</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Frontend Switcher -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Tampilan Luar</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('user.home') }}" class="sidebar-menu-link" target="_blank" title="Lihat Website Pihak Eksternal">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Halaman User (Depan)</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Sidebar Profile Card (Dynamic Footer) -->
  <div class="sidebar-profile">
    <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ Auth::user()->name ?? 'Wakasek Humas' }}" class="sidebar-profile-img"
      onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
    <div class="sidebar-profile-info">
      <div class="sidebar-profile-name d-flex align-items-center gap-1">
        <span>{{ Str::limit(Auth::user()->name ?? 'Wakasek Humas', 14) }}</span>
        <span class="badge bg-danger" style="font-size: 0.65rem;">Humas</span>
      </div>
      <div class="sidebar-profile-email">{{ Auth::user()->email ?? 'admin@sipesan.local' }}</div>
    </div>
  </div>
</div>
<!-- ==========================================
     END: Sidebar Component
     ========================================== -->
