@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- START: Dashboard Header Banner -->
<div class="page-header">
  <div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Sistem Pengelolaan & Pelayanan SIPESAN.</p>
  </div>
  <button class="btn-date-picker" type="button" id="date-picker-trigger">
    <i class="bi bi-calendar4-event"></i>
    <span id="selected-date-range">{{ date('F d, Y') }}</span>
    <i class="bi bi-chevron-down ms-1"></i>
  </button>
</div>
<!-- END: Dashboard Header Banner -->

<!-- START: Main Layout Grid (2 Columns: Dashboard + Performance Pane) -->
<div class="row g-4">

  <!-- TOP AREA: Quick Info Stat Cards Row (Full Width) -->
  <div class="col-12">
    <div class="row g-4">
      <!-- Stat Card 1: Green Alert Banner -->
      <div class="col-md-4">
        <div class="card alert-green-card">
          <div class="position-relative z-index-2">
            <span class="alert-green-badge">Pemberitahuan</span>
            <div class="alert-green-date">{{ date('d M Y') }}</div>
            <div class="alert-green-text">Sistem SIPESAN siap digunakan dengan template Spark Admin</div>
          </div>
          <a href="#" class="alert-green-link z-index-2" id="alert-link-statistics">
            <span>Lihat Detail</span>
            <i class="bi bi-arrow-right"></i>
          </a>

          <!-- Inline SVG geometric decoration -->
          <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(50,50)">
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
              <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
            </g>
          </svg>
        </div>
      </div>

      <!-- Stat Card 2: Net Income -->
      <div class="col-md-4">
        <div class="card card-stat d-flex flex-column justify-content-between">
          <div>
            <div class="card-header">
              <span class="stat-label">Pendapatan Bersih</span>
              <div class="dropdown">
                <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                  aria-label="More Options" id="btn-more-income">
                  <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Segarkan</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-arrow-down"></i> Ekspor Laporan</a></li>
                </ul>
              </div>
            </div>
            <div class="stat-value">Rp 196.000.000</div>
            <div class="trend-badge trend-up">
              <i class="bi bi-arrow-up-right"></i>
              <span>+35% dari bulan lalu</span>
            </div>
          </div>
          <div class="sparkline-container sparkline-card-footer">
            <div id="income-sparkline"></div>
          </div>
        </div>
      </div>

      <!-- Stat Card 3: Total Return -->
      <div class="col-md-4">
        <div class="card card-stat d-flex flex-column justify-content-between">
          <div>
            <div class="card-header">
              <span class="stat-label">Total Pesanan</span>
              <div class="dropdown">
                <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                  aria-label="More Options" id="btn-more-return">
                  <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                  <li><a class="dropdown-item" href="#"><i class="bi bi-arrow-repeat"></i> Segarkan</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-arrow-down"></i> Ekspor Laporan</a></li>
                </ul>
              </div>
            </div>
            <div class="stat-value">3.200</div>
            <div class="trend-badge trend-up">
              <i class="bi bi-arrow-up-right"></i>
              <span>+18% dari bulan lalu</span>
            </div>
          </div>
          <div class="sparkline-container sparkline-card-footer">
            <div id="return-sparkline"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: TOP AREA -->

  <!-- LEFT AREA: Primary Dashboard Stats & Tables -->
  <div class="col-xl-9 col-lg-8">

    <!-- START: Details Area (Transactions + Performance Charts) -->
    <div class="row g-4">
      <!-- Column: Revenue Chart (Full Width) -->
      <div class="col-12">
        <div class="card mb-0">
          <div class="card-header mb-2">
            <h2 class="card-title">Grafik Pendapatan</h2>
            <!-- Custom Static Legends -->
            <div class="d-flex gap-3 align-items-center">
              <div class="chart-legend-item">
                <span class="legend-dot bg-forest-medium"></span>
                <span class="chart-legend-label">Pemasukan</span>
              </div>
              <div class="chart-legend-item">
                <span class="legend-dot bg-lime-accent"></span>
                <span class="chart-legend-label">Pengeluaran</span>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-baseline gap-2 mb-3">
            <span class="stat-value-amount">Rp 196.000.000</span>
            <span class="trend-badge trend-up fs-xs">+35% dari bulan lalu</span>
          </div>
          <div id="revenue-chart"></div>
        </div>
      </div>

      <!-- Column: Transaction List -->
      <div class="col-md-7 d-flex flex-column">
        <div class="card h-100 flex-grow-1">
          <div class="card-header">
            <h2 class="card-title">Transaksi Terkini</h2>
            <div class="dropdown">
              <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="More Options" id="btn-more-transaction">
                <i class="bi bi-three-dots"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                <li><a class="dropdown-item" href="#"><i class="bi bi-funnel"></i> Filter Status</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-arrow-down"></i> Ekspor CSV</a></li>
              </ul>
            </div>
          </div>

          <!-- Transaction Items List -->
          <div class="transaction-list">
            <div class="transaction-item">
              <div class="transaction-icon bg-forest-light text-lime">
                <i class="bi bi-cart-check"></i>
              </div>
              <div class="transaction-info">
                <div class="transaction-name">Pesanan #SIP-0024</div>
                <div class="transaction-date">Hari ini • 12:40 WIB</div>
              </div>
              <div class="transaction-amount text-success">+Rp 450.000</div>
            </div>

            <div class="transaction-item">
              <div class="transaction-icon bg-forest-light text-lime">
                <i class="bi bi-cart-check"></i>
              </div>
              <div class="transaction-info">
                <div class="transaction-name">Pesanan #SIP-0023</div>
                <div class="transaction-date">Hari ini • 08:15 WIB</div>
              </div>
              <div class="transaction-amount text-success">+Rp 1.250.000</div>
            </div>

            <div class="transaction-item">
              <div class="transaction-icon bg-forest-light text-lime">
                <i class="bi bi-wallet2"></i>
              </div>
              <div class="transaction-info">
                <div class="transaction-name">Pembayaran Tagihan</div>
                <div class="transaction-date">Kemarin • 16:30 WIB</div>
              </div>
              <div class="transaction-amount text-danger">-Rp 350.000</div>
            </div>

            <div class="transaction-item">
              <div class="transaction-icon bg-forest-light text-lime">
                <i class="bi bi-cart-check"></i>
              </div>
              <div class="transaction-info">
                <div class="transaction-name">Pesanan #SIP-0022</div>
                <div class="transaction-date">Kemarin • 10:20 WIB</div>
              </div>
              <div class="transaction-amount text-success">+Rp 890.000</div>
            </div>
          </div>

        </div>
      </div>

      <!-- Column: Product Overview Progress -->
      <div class="col-md-5 d-flex flex-column">
        <div class="card h-100 flex-grow-1">
          <div class="card-header">
            <h2 class="card-title">Ringkasan Layanan</h2>
            <div class="dropdown">
              <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                aria-label="More Options" id="btn-more-products">
                <i class="bi bi-three-dots"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                <li><a class="dropdown-item" href="#"><i class="bi bi-plus-lg"></i> Tambah Item</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Kelola</a></li>
              </ul>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-label-row">
              <span class="progress-label">Pesanan Selesai</span>
              <span class="progress-value">233</span>
            </div>
            <div class="progress" role="progressbar" aria-label="Pesanan Selesai" aria-valuenow="65"
              aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar bg-lime-accent w-65"></div>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-label-row">
              <span class="progress-label">Pesanan Diproses</span>
              <span class="progress-value">23</span>
            </div>
            <div class="progress" role="progressbar" aria-label="Pesanan Diproses" aria-valuenow="20"
              aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar bg-lime-accent opacity-50 w-50"></div>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-label-row">
              <span class="progress-label">Total Pelanggan Aktif</span>
              <span class="progress-value">482</span>
            </div>
            <div class="progress" role="progressbar" aria-label="Pelanggan Aktif" aria-valuenow="85"
              aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar bg-lime-accent w-85"></div>
            </div>
          </div>

          <div class="progress-container">
            <div class="progress-label-row">
              <span class="progress-label">Pesanan Dibatalkan</span>
              <span class="progress-value">8</span>
            </div>
            <div class="progress" role="progressbar" aria-label="Pesanan Dibatalkan" aria-valuenow="10"
              aria-valuemin="0" aria-valuemax="100">
              <div class="progress-bar bg-brand-orange w-38"></div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- END: Details Area -->

  </div>

  <!-- RIGHT AREA: Performance Details Sidebar Panel -->
  <div class="col-xl-3 col-lg-4">
    <div class="right-panel-wrapper d-flex flex-column gap-4 h-100">

      <!-- Performance Donut Chart card -->
      <div class="card flex-grow-1 d-flex flex-column justify-content-between mb-0">
        <div class="card-header mb-1">
          <h2 class="card-title">Performa Layanan</h2>
        </div>

        <div id="views-chart"></div>

        <!-- Custom Legends below the chart -->
        <div class="chart-legends-container">
          <div class="chart-legend-item">
            <span class="legend-dot bg-lime-accent"></span>
            <span class="text-muted-green">Selesai</span>
          </div>
          <div class="chart-legend-item">
            <span class="legend-dot bg-forest-medium"></span>
            <span class="text-muted-green">Dalam Proses</span>
          </div>
          <div class="chart-legend-item">
            <span class="legend-dot bg-brand-orange"></span>
            <span class="text-muted-green">Pending</span>
          </div>
        </div>
      </div>

      <!-- Promotion CTA banner -->
      <div class="promo-banner-card">
        <svg class="promo-banner-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <g transform="translate(50,50)">
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
            <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
          </g>
        </svg>

        <h3 class="promo-title">SIPESAN Siap Digunakan!</h3>
        <p class="promo-desc">Kelola pesanan dan pelayanan dengan lebih cepat, rapi, dan terintegrasi.</p>
        <a href="{{ url('/blank') }}" class="btn-promo text-decoration-none d-inline-block text-center" id="btn-promo-action">Buka Halaman Baru</a>
      </div>
    </div>
  </div>
  <!-- END: RIGHT AREA -->

</div>
<!-- END: Main Layout Grid -->
@endsection
