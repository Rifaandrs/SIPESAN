@extends('layouts.app')

@section('title', 'Detail Saran - ' . $saran->kode_saran)

@section('content')
<!-- Header Detail Saran Sesuai Desain Panel 6 -->
<div class="page-header">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1">
      <h1 class="page-title mb-0">Detail Saran</h1>
      <span class="fs-5 fw-bold text-primary font-display">{{ $saran->kode_saran }}</span>
      <span class="badge rounded-pill px-3 py-1 {{ $saran->status_badge_class }}">
        {{ $saran->status }}
      </span>
    </div>
    <p class="page-subtitle">Verifikasi dan kelola tindak lanjut aspirasi pihak eksternal.</p>
  </div>
  <a href="{{ route('admin.saran.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
  </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- TWO COLUMNS LAYOUT SESUAI DESAIN PANEL 6 -->
<div class="row g-4">

  <!-- KOLOM KIRI: INFORMASI PENGIRIM & INFORMASI SARAN -->
  <div class="col-lg-7">
    
    <!-- 1. Informasi Pengirim -->
    <div class="card border-0 shadow-sm p-4 mb-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
        <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3">
          <i class="bi bi-person-badge fs-5"></i>
        </div>
        <h5 class="card-title fw-bold font-display mb-0">Informasi Pengirim</h5>
      </div>

      <div class="row g-3 small">
        <div class="col-sm-6">
          <span class="text-muted d-block">Nama Lengkap:</span>
          @if($saran->is_anonim)
            <span class="badge bg-secondary"><i class="bi bi-incognito me-1"></i> Anonim (Dirahasiakan)</span>
          @else
            <strong class="fs-6">{{ $saran->nama_pengirim }}</strong>
          @endif
        </div>

        <div class="col-sm-6">
          <span class="text-muted d-block">Status Pihak Eksternal:</span>
          <span class="badge bg-light text-dark border fs-6">{{ $saran->status_pengirim }}</span>
        </div>

        <div class="col-sm-12">
          <span class="text-muted d-block">Kontak (Email / No. HP):</span>
          @if($saran->is_anonim)
            <span class="text-muted fst-italic">Disembunyikan karena pengiriman anonim</span>
          @else
            <strong>{{ $saran->kontak_pengirim }}</strong>
          @endif
        </div>
      </div>
    </div>

    <!-- 2. Informasi Saran -->
    <div class="card border-0 shadow-sm p-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
        <div class="p-2 bg-success bg-opacity-10 text-success rounded-3">
          <i class="bi bi-chat-left-quote fs-5"></i>
        </div>
        <h5 class="card-title fw-bold font-display mb-0">Informasi Saran</h5>
      </div>

      <div class="mb-3">
        <span class="text-muted small d-block">Kategori:</span>
        <span class="badge bg-info text-dark">{{ $saran->category->nama ?? '-' }}</span>
      </div>

      <div class="mb-3">
        <span class="text-muted small d-block">Judul Saran:</span>
        <h5 class="fw-bold">{{ $saran->judul }}</h5>
      </div>

      <div class="mb-4">
        <span class="text-muted small d-block">Isi Saran / Kritik:</span>
        <div class="p-3 bg-light rounded-3 mt-1" style="white-space: pre-wrap; line-height: 1.6;">
          {{ $saran->isi }}
        </div>
      </div>

      <!-- Lampiran -->
      <div>
        <span class="text-muted small d-block mb-1">Lampiran Dokumen / Foto:</span>
        @if($saran->lampiran)
          @php
            $ext = pathinfo($saran->lampiran, PATHINFO_EXTENSION);
          @endphp
          @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
            <div class="mt-2">
              <a href="{{ asset($saran->lampiran) }}" target="_blank">
                <img src="{{ asset($saran->lampiran) }}" alt="Lampiran" class="img-thumbnail rounded-3" style="max-height: 200px;">
              </a>
              <div class="small text-muted mt-1">Klik gambar untuk melihat ukuran penuh.</div>
            </div>
          @else
            <a href="{{ asset($saran->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-1">
              <i class="bi bi-paperclip me-1"></i> Unduh Lampiran ({{ strtoupper($ext) }})
            </a>
          @endif
        @else
          <span class="text-muted fst-italic small">Tidak ada lampiran disertakan.</span>
        @endif
      </div>

    </div>

  </div>

  <!-- KOLOM KANAN: FORM TINDAK LANJUT & RIWAYAT STATUS -->
  <div class="col-lg-5">
    
    <!-- 1. Form Tindak Lanjut Sesuai Desain Panel 6 -->
    <div class="card border-0 shadow-sm p-4 mb-4 bg-white">
      <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
        <div class="p-2 bg-warning bg-opacity-25 text-dark rounded-3">
          <i class="bi bi-pencil-square fs-5"></i>
        </div>
        <h5 class="card-title fw-bold font-display mb-0">Tindak Lanjut</h5>
      </div>

      <form action="{{ route('admin.saran.updateStatus', $saran->id) }}" method="POST">
        @csrf

        <!-- Status -->
        <div class="mb-3">
          <label class="form-label small fw-semibold" for="status">
            Status <span class="text-danger">*</span>
          </label>
          <select name="status" id="status" class="form-select" required>
            <option value="Baru" {{ $saran->status == 'Baru' ? 'selected' : '' }}>Baru</option>
            <option value="Diterima" {{ $saran->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
            <option value="Sedang Diverifikasi" {{ $saran->status == 'Sedang Diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
            <option value="Dalam Proses Tindak Lanjut" {{ $saran->status == 'Dalam Proses Tindak Lanjut' ? 'selected' : '' }}>Dalam Proses Tindak Lanjut</option>
            <option value="Selesai" {{ $saran->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Ditolak" {{ $saran->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
          </select>
        </div>

        <!-- Ditujukan Kepada -->
        <div class="mb-3">
          <label class="form-label small fw-semibold" for="ditujukan_kepada">
            Ditujukan Kepada
          </label>
          <input type="text" name="ditujukan_kepada" id="ditujukan_kepada" class="form-control"
                 placeholder="Contoh: Bagian Sarana dan Prasarana"
                 value="{{ old('ditujukan_kepada', $saran->ditujukan_kepada) }}">
          <div class="form-text small text-muted">
            Unit kerja / bagian sekolah yang menangani saran ini.
          </div>
        </div>

        <!-- Catatan Tindak Lanjut -->
        <div class="mb-3">
          <label class="form-label small fw-semibold" for="catatan_tindak_lanjut">
            Catatan Tindak Lanjut
          </label>
          <textarea name="catatan_tindak_lanjut" id="catatan_tindak_lanjut" class="form-control" rows="4"
                    placeholder="Tuliskan catatan disposisi atau hasil tindak lanjut...">{{ old('catatan_tindak_lanjut', $saran->catatan_tindak_lanjut) }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-save me-1"></i> Simpan
          </button>
          <a href="{{ route('admin.saran.index') }}" class="btn btn-light border px-3">
            Batal
          </a>
        </div>
      </form>
    </div>

    <!-- 2. Riwayat Status (Timeline) Sesuai Desain Panel 6 -->
    <div class="card border-0 shadow-sm p-4 bg-white">
      <h6 class="fw-bold font-display mb-3 pb-2 border-bottom">
        <i class="bi bi-clock-history me-1"></i> Riwayat Status
      </h6>

      <div class="timeline-stepper ps-3 position-relative status-history-list">
        @forelse($saran->histories as $hist)
          <div class="position-relative pb-3 ps-3 status-history-item">
            <div class="position-absolute status-history-marker">
              <span class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm">
                <i class="bi bi-check"></i>
              </span>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-baseline gap-1 status-history-heading">
              <span class="fw-semibold">{{ $hist->status }}</span>
              <time class="text-muted" datetime="{{ $hist->created_at->toIso8601String() }}">{{ $hist->created_at->format('d/m/Y H:i') }}</time>
            </div>
            <p class="text-muted mb-0 status-history-note">{{ $hist->catatan }}</p>
          </div>
        @empty
          <span class="text-muted small">Belum ada catatan riwayat.</span>
        @endforelse
      </div>
    </div>

  </div>

</div>
@endsection
