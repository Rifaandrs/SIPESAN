@extends('layouts.user')

@section('title', 'Saran Berhasil Dikirim - SIPESAN')

@section('content')
<div class="py-5" style="background: var(--clr-bg); min-height: 85vh; display: grid; place-items: center;">
  <div class="container" style="max-width: 600px;">

    <!-- Card Konfirmasi Kode Sesuai Desain Panel 3 -->
    <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 text-center bg-white" data-aos="zoom-in">
      
      <!-- Green Check Icon -->
      <div class="mx-auto mb-3 text-success" style="font-size: 4.5rem; line-height: 1;">
        <i class="bi bi-check-circle-fill"></i>
      </div>

      <h3 class="font-display fw-bold mb-2">Saran Berhasil Dikirim!</h3>
      <p class="text-muted mb-4">
        Terima kasih telah menyampaikan saran Anda. Simpan kode saran berikut untuk memantau proses tindak lanjut.
      </p>

      <!-- Kode Saran Highlight Box -->
      <div class="p-4 rounded-4 mb-4 border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
        <span class="text-muted text-uppercase fw-semibold small d-block mb-1" style="letter-spacing: 0.05em;">
          Kode Saran
        </span>
        <div class="d-flex align-items-center justify-content-center gap-2">
          <span class="font-display fw-bold fs-2 text-dark" id="kodeSaranText">
            {{ $saran->kode_saran }}
          </span>
          <button type="button" class="btn btn-sm btn-outline-success rounded-circle" id="btnCopyKode" 
                  title="Salin Kode Saran" onclick="copyKodeSaran('{{ $saran->kode_saran }}')">
            <i class="bi bi-clipboard" id="copyIcon"></i>
          </button>
        </div>
        <small class="text-success d-none mt-2 fw-semibold" id="copyAlert">
          <i class="bi bi-check2"></i> Kode berhasil disalin ke clipboard!
        </small>
      </div>

      <!-- Action Buttons Sesuai Desain Panel 3 -->
      <div class="d-grid gap-2 mb-3">
        <a href="{{ route('user.saran.status', ['kode' => $saran->kode_saran]) }}" class="btn-hw-primary justify-content-center py-3">
          <i class="bi bi-search me-1"></i> Lihat Status Saran
        </a>
        <a href="{{ route('user.home') }}" class="btn btn-light rounded-pill py-2 fw-semibold text-muted border">
          <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
        </a>
      </div>

      <div class="text-muted small">
        Kategori: <strong>{{ $saran->category->nama ?? '-' }}</strong> &bull; {{ $saran->created_at->format('d M Y, H:i') }} WIB
      </div>

    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function copyKodeSaran(kode) {
  navigator.clipboard.writeText(kode).then(() => {
    const alertEl = document.getElementById('copyAlert');
    const iconEl = document.getElementById('copyIcon');
    alertEl.classList.remove('d-none');
    iconEl.className = 'bi bi-check-lg';
    setTimeout(() => {
      alertEl.classList.add('d-none');
      iconEl.className = 'bi bi-clipboard';
    }, 2500);
  });
}
</script>
@endpush
