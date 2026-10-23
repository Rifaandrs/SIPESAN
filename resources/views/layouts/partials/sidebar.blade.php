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
            <span>Dasbor</span>
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

        <!-- 4. Laporan -->
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
      <div class="sidebar-menu-title">Tampilan User</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('user.home', ['transition' => 'admin']) }}" class="sidebar-menu-link" target="_blank" title="Lihat Website Pihak Eksternal">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Halaman User</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- ==========================================
     END: Sidebar Component
     ========================================== -->
