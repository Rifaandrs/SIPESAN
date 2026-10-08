<!-- ==========================================
     START: Sidebar Component
     ========================================== -->
<div class="sidebar-wrapper" id="sidebar">
  <!-- Brand Logo / Identity -->
  <a href="{{ url('/') }}" class="sidebar-brand">
    <i class="bi bi-asterisk"></i>
    <span>SIPESAN</span>
  </a>

  <!-- Navigation Menu -->
  <div class="flex-grow-1 overflow-y-auto">
    <!-- Group: Menu -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Menu</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ url('/') }}" class="sidebar-menu-link {{ request()->is('/') ? 'active' : '' }}" id="menu-overview" title="Overview">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Pages -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Pages</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ url('/blank') }}" class="sidebar-menu-link {{ request()->is('blank') ? 'active' : '' }}" id="menu-blankpage" title="Blank Page">
            <i class="bi bi-file-earmark"></i>
            <span>Blank Page</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Sidebar Profile Card (Dynamic Footer) -->
  <div class="sidebar-profile">
    <img src="{{ asset('assets/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img"
      onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
    <div class="sidebar-profile-info">
      <div class="sidebar-profile-name">Administrator</div>
      <div class="sidebar-profile-email">admin@sipesan.local</div>
    </div>
  </div>
</div>
<!-- ==========================================
     END: Sidebar Component
     ========================================== -->
