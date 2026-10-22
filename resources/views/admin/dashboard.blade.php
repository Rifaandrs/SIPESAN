@extends('layouts.app')

@section('title', 'Dashboard Wakasek Humas')

@section('content')
<!-- START: Header Banner Sesuai Desain Panel 5 -->
<div class="page-header">
  <div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Selamat datang, <strong>{{ Auth::user()->name ?? 'Wakasek Humas' }}</strong> (Admin)</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('user.home') }}" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 rounded-pill px-3">
      <i class="bi bi-box-arrow-up-right"></i>
      <span>Tampilan Depan (User)</span>
    </a>
    <a href="{{ route('admin.saran.index') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 rounded-pill px-3">
      <i class="bi bi-chat-left-text-fill"></i>
      <span>Kelola Saran</span>
    </a>
  </div>
</div>
<!-- END: Header Banner -->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- 4 STAT CARDS SESUAI DESAIN PANEL 5 -->
<div class="row g-4 mb-4">
  
  <!-- 1. Total Saran (Blue) -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-stat border-0 shadow-sm p-4 h-100" style="border-left: 4px solid #2563eb !important;">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="stat-label text-primary fw-bold">Total Saran</span>
        <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-4">
          <i class="bi bi-chat-square-text-fill"></i>
        </div>
      </div>
      <div class="stat-value text-dark fw-bold fs-2">{{ $totalSaran }}</div>
      <small class="text-muted">Semua saran pihak eksternal</small>
    </div>
  </div>

  <!-- 2. Saran Baru (Orange) -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-stat border-0 shadow-sm p-4 h-100" style="border-left: 4px solid #f97316 !important;">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="stat-label text-warning fw-bold">Saran Baru</span>
        <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-3 fs-4">
          <i class="bi bi-envelope-open-fill"></i>
        </div>
      </div>
      <div class="stat-value text-dark fw-bold fs-2">{{ $saranBaru }}</div>
      <small class="text-warning fw-semibold">Menunggu verifikasi Humas</small>
    </div>
  </div>

  <!-- 3. Diproses (Yellow/Amber) -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-stat border-0 shadow-sm p-4 h-100" style="border-left: 4px solid #eab308 !important;">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="stat-label text-dark fw-bold">Diproses</span>
        <div class="p-2 bg-warning bg-opacity-25 text-dark rounded-3 fs-4">
          <i class="bi bi-hourglass-split"></i>
        </div>
      </div>
      <div class="stat-value text-dark fw-bold fs-2">{{ $saranDiproses }}</div>
      <small class="text-muted">Dalam tindak lanjut unit terkait</small>
    </div>
  </div>

  <!-- 4. Selesai (Green) -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-stat border-0 shadow-sm p-4 h-100" style="border-left: 4px solid #16a34a !important;">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="stat-label text-success fw-bold">Selesai</span>
        <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 fs-4">
          <i class="bi bi-check-circle-fill"></i>
        </div>
      </div>
      <div class="stat-value text-dark fw-bold fs-2">{{ $saranSelesai }}</div>
      <small class="text-success fw-semibold">Telah ditindaklanjuti tuntas</small>
    </div>
  </div>

</div>

<!-- ROW: STATISTIK PER KATEGORI & DAFTAR SARAN TERBARU (PANEL 5) -->
<div class="row g-4">

  <!-- Bagian Kiri: Donut / Bar Chart Statistik Saran per Kategori -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm p-4 h-100 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title fw-bold font-display mb-0">Statistik Saran per Kategori</h5>
        <span class="badge bg-light text-dark border">{{ $categoriesStats->count() }} Kategori</span>
      </div>

      <!-- Donut Chart Container -->
      <div id="category-donut-chart" class="my-2"></div>

      <!-- Progress List Breakdown -->
      <div class="mt-3">
        @foreach($categoriesStats as $cs)
          @php
            $percentage = $totalSaran > 0 ? round(($cs->sarans_count / $totalSaran) * 100) : 0;
          @endphp
          <div class="mb-3">
            <div class="d-flex justify-content-between small fw-semibold mb-1">
              <span>{{ $cs->nama }}</span>
              <span class="text-muted">{{ $cs->sarans_count }} ({{ $percentage }}%)</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%;" 
                   aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Bagian Kanan: Daftar Saran Terbaru Sesuai Desain Panel 5 -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm p-4 h-100 bg-white">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="card-title fw-bold font-display mb-0">Daftar Saran Terbaru</h5>
          <span class="text-muted small">Aspirasi masuk dari pihak eksternal</span>
        </div>
        <a href="{{ route('admin.saran.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
          Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle table-hover">
          <thead class="table-light">
            <tr>
              <th>Kode</th>
              <th>Pengirim</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentSarans as $rs)
            <tr>
              <td>
                <strong class="text-primary">{{ $rs->kode_saran }}</strong>
              </td>
              <td>
                <div class="fw-semibold">{{ $rs->nama_tampilan }}</div>
                <small class="text-muted">{{ $rs->status_pengirim }}</small>
              </td>
              <td>
                <span class="small">{{ $rs->category->nama ?? '-' }}</span>
              </td>
              <td class="text-muted small">
                {{ $rs->created_at->format('d/m/y') }}
              </td>
              <td>
                <span class="badge rounded-pill px-2 py-1 {{ $rs->status_badge_class }}">
                  {{ $rs->status }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.saran.show', $rs->id) }}" class="btn btn-sm btn-primary rounded-pill px-2 py-0" style="font-size: 0.75rem;">
                  Detail
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Belum ada saran masuk.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($recentSarans->hasPages())
        <div class="mt-3 pt-2 border-top d-flex flex-wrap justify-content-between align-items-center small text-muted">
          <div>Menampilkan {{ $recentSarans->firstItem() }} - {{ $recentSarans->lastItem() }} dari {{ $recentSarans->total() }} saran</div>
          <div>{{ $recentSarans->links() }}</div>
        </div>
      @endif

    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const activeStats = @json($categoriesStats->where('sarans_count', '>', 0)->values());
  const categoriesData = activeStats.length > 0 
      ? activeStats.map(item => item.sarans_count) 
      : @json($categoriesStats->pluck('sarans_count'));
  const categoriesLabels = activeStats.length > 0 
      ? activeStats.map(item => item.nama) 
      : @json($categoriesStats->pluck('nama'));

  if (document.getElementById('category-donut-chart') && categoriesData.length > 0) {
    const options = {
      series: categoriesData,
      labels: categoriesLabels,
      chart: {
        type: 'donut',
        height: 240,
        fontFamily: 'inherit'
      },
      colors: ['#204F97', '#3667AC', '#477DBD', '#609CD0', '#78B3DF', '#92C6EB', '#AEDAF3'],
      legend: {
        show: false
      },
      dataLabels: {
        enabled: false
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + " Saran";
          }
        }
      }
    };
    const chart = new ApexCharts(document.getElementById('category-donut-chart'), options);
    chart.render();
  }
});
</script>
@endpush
