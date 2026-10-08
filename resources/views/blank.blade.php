@extends('layouts.app')

@section('title', 'Blank Page')

@section('content')
<!-- START: Page Header Banner -->
<div class="page-header">
  <div>
    <h1 class="page-title">Blank Page</h1>
    <p class="page-subtitle">Halaman kosong awal untuk membangun fitur baru SIPESAN.</p>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted-green">Home</a></li>
      <li class="breadcrumb-item active text-main" aria-current="page">Blank Page</li>
    </ol>
  </nav>
</div>
<!-- END: Page Header Banner -->

<!-- START: Blank Page Content Area -->
<div class="card p-4 border-light shadow-sm text-center">
  <div>
    <div class="mb-4 text-lime empty-state-icon">
      <i class="bi bi-file-earmark-fill"></i>
    </div>
    <h3 class="mb-2">Konten Anda Dimulai Di Sini</h3>
    <p class="text-muted-green mb-4">Gunakan template halaman kosong ini untuk membangun modul, tabel, form, atau fitur lainnya di sistem SIPESAN.</p>
  </div>
</div>
<!-- END: Blank Page Content Area -->
@endsection
