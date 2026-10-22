@extends('layouts.user')

@section('title', 'Dashboard Pihak Eksternal')

@section('content')
<div class="py-5" style="background: var(--clr-bg); min-height: 85vh;">
  <div class="container">
    
    <!-- Header Dashboard -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 p-4 bg-white rounded-4 shadow-sm" data-aos="fade-down">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1">
          <h2 class="font-display fw-bold mb-0">Dashboard Pengguna</h2>
          <span class="badge bg-success rounded-pill px-3 py-2">
            <i class="bi bi-person-check-fill me-1"></i> Pihak Eksternal
          </span>
        </div>
        <p class="text-muted mb-0">Selamat datang, <strong>{{ $user->name }}</strong> ({{ $user->email }}).</p>
      </div>
      <div class="d-flex gap-2 mt-3 mt-md-0">
        <a href="{{ route('user.saran.create') }}" class="btn btn-primary rounded-pill px-3">
          <i class="bi bi-plus-circle me-1"></i> Sampaikan Saran Baru
        </a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-outline-danger rounded-pill px-3">
            <i class="bi bi-box-arrow-right me-1"></i> Keluar
          </button>
        </form>
      </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-4" data-aos="fade-up">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted fw-semibold">Total Saran Anda</span>
            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-4">
              <i class="bi bi-chat-square-text"></i>
            </div>
          </div>
          <h3 class="fw-bold font-display mb-1">{{ $totalKirim }}</h3>
          <span class="text-muted small">Tersimpan di akun Anda</span>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted fw-semibold">Sedang Diproses</span>
            <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-3 fs-4">
              <i class="bi bi-hourglass-split"></i>
            </div>
          </div>
          <h3 class="fw-bold font-display mb-1 text-warning">{{ $totalProses }}</h3>
          <span class="text-warning small fw-semibold">Ditinjau / ditindaklanjuti</span>
        </div>
      </div>

      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 rounded-4 shadow-sm p-4 h-100 bg-white">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted fw-semibold">Tuntas Selesai</span>
            <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 fs-4">
              <i class="bi bi-check2-circle"></i>
            </div>
          </div>
          <h3 class="fw-bold font-display mb-1 text-success">{{ $totalSelesai }}</h3>
          <span class="text-success small fw-semibold">Saran telah diselesaikan</span>
        </div>
      </div>
    </div>

    <!-- Tabel Riwayat Saran Pengguna -->
    <div class="card border-0 rounded-4 shadow-sm p-4 bg-white" data-aos="fade-up">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold font-display mb-0">Riwayat Saran Yang Anda Kirimkan</h5>
        <a href="{{ route('user.saran.create') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
          <i class="bi bi-pencil-square me-1"></i> Tulis Saran
        </a>
      </div>

      <div class="table-responsive">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Kode Saran</th>
              <th>Judul Saran</th>
              <th>Kategori</th>
              <th>Tanggal Kirim</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($sarans as $s)
            <tr>
              <td><strong class="text-primary">{{ $s->kode_saran }}</strong></td>
              <td>{{ Str::limit($s->judul, 40) }}</td>
              <td><span class="badge bg-light text-dark border">{{ $s->category->nama ?? '-' }}</span></td>
              <td class="text-muted small">{{ $s->created_at->format('d M Y, H:i') }}</td>
              <td>
                <span class="badge rounded-pill px-3 py-1 {{ $s->status_badge_class }}">
                  {{ $s->status }}
                </span>
              </td>
              <td>
                <a href="{{ route('user.saran.status', ['kode' => $s->kode_saran]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                  <i class="bi bi-search me-1"></i> Lacak
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">
                Anda belum pernah mengirimkan saran. Silakan klik tombol "Sampaikan Saran Baru".
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($sarans->hasPages())
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
          <div>Menampilkan {{ $sarans->firstItem() }} sampai {{ $sarans->lastItem() }} dari total {{ $sarans->total() }} saran</div>
          <div>{{ $sarans->links() }}</div>
        </div>
      @endif
    </div>

  </div>
</div>
@endsection
