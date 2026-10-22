@extends('layouts.app')

@section('title', 'Blank Page')

@section('content')
<!-- START: Header Banner -->
<div class="page-header">
  <div>
    <h1 class="page-title">Halaman Kosong (Blank Page)</h1>
    <p class="page-subtitle">Gunakan halaman ini sebagai template awal untuk fitur baru.</p>
  </div>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
  </a>
</div>
<!-- END: Header Banner -->

<div class="card border-0 shadow-sm p-4">
  <div class="text-center py-5">
    <i class="bi bi-file-earmark-plus text-muted" style="font-size: 3rem;"></i>
    <h4 class="mt-3 font-display fw-bold">Halaman Siap Digunakan</h4>
    <p class="text-muted">Mulai kembangkan modul baru sistem SIPESAN di sini.</p>
  </div>
</div>
@endsection
