@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Role')

@section('content')
<!-- START: Header Banner -->
<div class="page-header">
  <div>
    <h1 class="page-title">Manajemen User &amp; Role</h1>
    <p class="page-subtitle">Kelola akun terdaftar dan atur hak akses (Admin / User) di sistem SIPESAN.</p>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
  </a>
</div>
<!-- END: Header Banner -->

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mb-4 border-0 shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center">
    <div>
      <h2 class="card-title mb-0">Daftar Akun Pengguna</h2>
      <span class="text-muted small">Total akun terdaftar: {{ $users->total() }}</span>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Nama Lengkap</th>
          <th>Email</th>
          <th>Role Saat Ini</th>
          <th>Terdaftar Pada</th>
          <th>Ubah Peran (Role)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $index => $u)
        <tr>
          <td class="text-muted">{{ $users->firstItem() + $index }}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle {{ $u->role === 'admin' ? 'bg-danger text-white' : 'bg-success text-white' }} d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px;">
                {{ strtoupper(substr($u->name, 0, 1)) }}
              </div>
              <div>
                <div class="fw-semibold">{{ $u->name }}</div>
                @if(Auth::id() === $u->id)
                  <span class="badge bg-secondary" style="font-size: 0.65rem;">Akun Anda</span>
                @endif
              </div>
            </div>
          </td>
          <td>{{ $u->email }}</td>
          <td>
            @if($u->role === 'admin')
              <span class="badge bg-danger rounded-pill px-3 py-2"><i class="bi bi-shield-lock-fill me-1"></i> Admin (Wakasek Humas)</span>
            @else
              <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-person-fill me-1"></i> User (Pihak Eksternal)</span>
            @endif
          </td>
          <td class="text-muted small">{{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }}</td>
          <td>
            @if(Auth::id() === $u->id)
              <span class="text-muted small fst-italic">Akun aktif saat ini</span>
            @else
              <form action="{{ route('admin.users.updateRole', $u->id) }}" method="POST" class="d-inline-flex align-items-center gap-1">
                @csrf
                <select name="role" class="form-select form-select-sm" style="width: 170px;">
                  <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User (Pihak Eksternal)</option>
                  <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin (Wakasek Humas)</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary" title="Simpan Perubahan">
                  <i class="bi bi-check-lg"></i>
                </button>
              </form>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-4 text-muted">Belum ada akun pengguna.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($users->hasPages())
    <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
    </div>
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
  <div class="card-footer bg-white py-3 d-flex justify-content-center">
    {{ $users->links() }}
  </div>
  @endif
</div>
@endsection
