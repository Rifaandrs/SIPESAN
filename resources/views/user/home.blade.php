@extends('layouts.user')

@section('title', 'Beranda - Sistem Pelayanan Saran Eksternal')

@section('content')

<!-- ============================================
     HERO SECTION (Panel 1 Desain)
============================================ -->
@push('styles')
<style>
  .hero-sipesan {
    position: relative;
    padding: 50px 0 85px;
    background: radial-gradient(circle at 18% 20%, #EEF7FE 0, var(--clr-bg) 55%);
    overflow: hidden;
  }

  .home-statistics {
    padding-bottom: 0.5rem !important;
  }

  #features.section-pad {
    padding-top: 3rem;
  }

  .home-content-section.section-pad {
    padding-block: 3.5rem;
  }

  .hero-poster-wrapper {
    position: relative;
    padding: 10px 15px 10px 0;
  }

  .hero-poster-frame {
    position: relative;
    border-radius: 22px;
    overflow: hidden;
    aspect-ratio: 1442 / 726;
    box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.05);
    background: #e2e8f0;
  }

  .hero-poster-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    transition: transform 0.35s ease;
  }

  .hero-poster-frame:hover .hero-poster-img {
    transform: scale(1.015);
  }

  /* Posisi & Ukuran Floating Card 1: Kanan Atas (Saran Masuk - Dibuat Lebih Kecil & Ramping) */
  .float-card-mockup-1 {
    top: 6%;
    right: -12px;
    left: auto !important;
    width: auto !important;
    max-width: max-content !important;
    white-space: nowrap !important;
    padding: 6px 12px;
    border-radius: 12px;
    gap: 8px;
    animation-delay: 0s;
    z-index: 2;
  }

  .float-card-mockup-1 .fc-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    font-size: 0.82rem;
  }

  .float-card-mockup-1 .fc-val {
    font-size: 0.9rem;
  }

  .float-card-mockup-1 .fc-label {
    font-size: 0.64rem;
  }

  /* Posisi & Ukuran Floating Card 2: Kanan Bawah (Tuntas Ditindaklanjuti) */
  .float-card-mockup-2 {
    bottom: 6%;
    right: -16px;
    left: auto !important;
    width: auto !important;
    max-width: max-content !important;
    white-space: nowrap !important;
    padding: 8px 13px;
    border-radius: 13px;
    gap: 9px;
    animation-delay: 1.5s;
    z-index: 2;
  }

  .float-card-mockup-2 .fc-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    font-size: 0.95rem;
  }

  .float-card-mockup-2 .fc-val {
    font-size: 0.95rem;
  }

  .float-card-mockup-2 .fc-label {
    font-size: 0.68rem;
  }

  @media (max-width: 1199.98px) {
    .float-card-mockup-1 {
      right: -8px;
    }
    .float-card-mockup-2 {
      right: -8px;
    }
  }

  @media (max-width: 991.98px) {
    .hero-sipesan {
      padding: 50px 0 45px;
    }
    .hero-poster-wrapper {
      padding: 0;
      margin-top: 1.8rem;
    }
    .float-card-mockup-1,
    .float-card-mockup-2 {
      position: static;
      display: inline-flex;
      margin-top: 12px;
      margin-right: 12px;
      animation: none;
    }
  }

  @media (max-width: 767.98px) {
    #features.section-pad {
      padding-top: 2rem;
    }

    .home-content-section.section-pad {
      padding-block: 2.5rem;
    }
  }

  /* Tombol Aksi Hero: Putih Bersih di Awal, Berubah Biru Saat di-Hover */
  .btn-hw-white-hover {
    background-color: #ffffff;
    border: 2px solid var(--clr-primary);
    color: var(--clr-primary);
    padding: 0.65rem 1.4rem;
    border-radius: 999px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
  }

  .btn-hw-white-hover:hover {
    background-color: var(--clr-primary);
    color: #ffffff;
    border-color: var(--clr-primary);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px -8px rgba(54, 103, 172, 0.45);
  }
</style>
@endpush

<!-- ============================================
     HERO SECTION (Panel 1 Desain Sesuai Mockup)
============================================ -->
<header class="hero hero-sipesan" id="home">
  <div class="hero-glow"></div>
  <span class="blob blob-1"></span>
  <span class="blob blob-2"></span>
  <span class="blob blob-3"></span>
  <div class="container position-relative">
    <div class="row align-items-center g-5">
      <!-- Kolom Kiri: Teks & Tombol Aksi -->
      <div class="col-lg-5" data-aos="fade-right">
        <span class="eyebrow"><i class="bi bi-mortarboard-fill"></i> SIPESAN SMPN 2 PURWAKARTA</span>
        <h1 class="hero-title mt-3">
          Sistem Pelayanan Saran Eksternal <span class="accent-underline">SMPN 2 Purwakarta<svg viewBox="0 0 200 14" preserveAspectRatio="none"><path d="M2 10 Q 50 2 100 8 T 198 6" stroke="#204F97" stroke-width="5" fill="none" stroke-linecap="round"/></svg></span>
        </h1>
        <p class="hero-lead mt-4">
          Sampaikan saran, kritik, dan masukan Anda untuk membantu meningkatkan kualitas pelayanan dan lingkungan pendidikan SMPN 2 Purwakarta.
        </p>
        
        <!-- Dua Tombol Aksi Utama (Putih Bersih di Awal, Berubah Biru Saat di-Hover) -->
        <div class="d-flex flex-wrap gap-3 mt-4">
          <a href="{{ route('user.saran.create') }}" class="btn-hw-white-hover">
            <i class="bi bi-chat-left-dots-fill"></i> Sampaikan Saran
          </a>
          <a href="{{ route('user.saran.status') }}" class="btn-hw-white-hover">
            <i class="bi bi-search"></i> Cek Status Saran
          </a>
        </div>
      </div>
      
      <!-- Kolom Kanan: Poster Banner 16:9 Landscape dengan Floating Badges Sesuai Mockup -->
      <div class="col-lg-7" data-aos="fade-left" data-aos-delay="120">
        <div class="hero-poster-wrapper">
          <div class="hero-poster-frame shadow-lg">
            <img src="{{ asset('assets/images/smpn-2-purwakarta-banner.png') }}"
                 alt="SMPN 2 Purwakarta CEKAS (Cerdas Edukatif Kreatif Akuntabel Super)"
                 loading="eager" class="hero-poster-img">
          </div>
          <!-- Floating Badge 1: Kanan Atas (Saran Masuk) -->
          <div class="float-card float-card-1 float-card-mockup-1 shadow-lg">
            <span class="fc-icon"><i class="bi bi-chat-square-text-fill"></i></span>
            <div>
              <div class="fc-val">{{ $totalSaran }}</div>
              <div class="fc-label">Saran Masuk</div>
            </div>
          </div>
          <!-- Floating Badge 2: Kanan Bawah (Tuntas Ditindaklanjuti) -->
          <div class="float-card float-card-2 float-card-mockup-2 shadow-lg">
            <span class="fc-icon"><i class="bi bi-patch-check-fill"></i></span>
            <div>
              <div class="fc-val">{{ $saranSelesai }}</div>
              <div class="fc-label">Tuntas Ditindaklanjuti</div>
            </div>
          </div>
        </div>

        <!-- Layanan Saran Terpadu di Bawah Poster -->
        <div class="d-flex align-items-center gap-3 mt-3 pt-2">
          <div class="d-flex">
            <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; background-color: var(--clr-primary) !important;">
              <i class="bi bi-check-lg fs-5"></i>
            </div>
          </div>
          <div>
            <div class="fw-bold font-display" style="font-size: .95rem;">Layanan Saran Terpadu</div>
            <div class="text-muted" style="font-size: .82rem;">Dikelola langsung oleh Tim Wakasek Hubungan Masyarakat (Humas)</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<section class="home-statistics py-5" style="background: var(--clr-bg);" id="statistik" aria-label="Statistik saran">
  <div class="container">
    
    <!-- 4 Kartu Ringkasan Statistik Status Sesuai Data Tercatat -->
    <div class="row g-3 g-md-4" data-aos="fade-up">
      <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-left: 4px solid #2563eb !important;">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small fw-semibold text-primary">Total Saran</span>
            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-5">
              <i class="bi bi-chat-square-text-fill"></i>
            </div>
          </div>
          <div class="fw-bold fs-3 text-dark mb-0 font-display">{{ $totalSaran }}</div>
          <small class="text-muted" style="font-size: 0.78rem;">Semua saran tercatat</small>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-left: 4px solid #f97316 !important;">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small fw-semibold text-warning">Saran Baru</span>
            <div class="p-2 bg-warning bg-opacity-10 text-warning rounded-3 fs-5">
              <i class="bi bi-envelope-open-fill"></i>
            </div>
          </div>
          <div class="fw-bold fs-3 text-dark mb-0 font-display">{{ $saranBaru }}</div>
          <small class="text-muted" style="font-size: 0.78rem;">Menunggu verifikasi</small>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-left: 4px solid #eab308 !important;">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small fw-semibold text-dark">Sedang Diproses</span>
            <div class="p-2 bg-warning bg-opacity-25 text-dark rounded-3 fs-5">
              <i class="bi bi-hourglass-split"></i>
            </div>
          </div>
          <div class="fw-bold fs-3 text-dark mb-0 font-display">{{ $saranDiproses }}</div>
          <small class="text-muted" style="font-size: 0.78rem;">Tindak lanjut unit</small>
        </div>
      </div>

      <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-4 shadow-sm p-3 p-md-4 h-100 bg-white" style="border-left: 4px solid #16a34a !important;">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="small fw-semibold text-success">Tuntas Selesai</span>
            <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 fs-5">
              <i class="bi bi-check-circle-fill"></i>
            </div>
          </div>
          <div class="fw-bold fs-3 text-dark mb-0 font-display">{{ $saranSelesai }}</div>
          <small class="text-muted" style="font-size: 0.78rem;">Tuntas ditindaklanjuti</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     3 PILAR NILAI (Panel 1 Desain Bawah)
============================================ -->
<section class="section-pad home-content-section" id="features">
  <div class="container">
    <div class="row g-4">
      
      <!-- Card 1: Transparan -->
      <div class="col-md-4" data-aos="fade-up">
        <div class="card h-100 p-4 border-0 rounded-4 shadow-sm text-center bg-white">
          <div class="mx-auto mb-3 p-3 bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 70px; height: 70px; display: grid; place-items: center;">
            <i class="bi bi-people-fill fs-2"></i>
          </div>
          <h4 class="font-display fw-bold mb-2">Transparan</h4>
          <p class="text-muted mb-0">Semua saran akan diproses dengan baik, terbuka, dan dapat dipantau perkembangannya.</p>
        </div>
      </div>

      <!-- Card 2: Responsif -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 p-4 border-0 rounded-4 shadow-sm text-center bg-white">
          <div class="mx-auto mb-3 p-3 bg-success bg-opacity-10 text-success rounded-circle" style="width: 70px; height: 70px; display: grid; place-items: center;">
            <i class="bi bi-shield-check fs-2"></i>
          </div>
          <h4 class="font-display fw-bold mb-2">Responsif</h4>
          <p class="text-muted mb-0">Setiap saran akan ditindaklanjuti secara tanggap dan akuntabel sesuai prosedur sekolah.</p>
        </div>
      </div>

      <!-- Card 3: Bersama -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 p-4 border-0 rounded-4 shadow-sm text-center bg-white">
          <div class="mx-auto mb-3 p-3 bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 70px; height: 70px; display: grid; place-items: center;">
            <i class="bi bi-graph-up-arrow fs-2"></i>
          </div>
          <h4 class="font-display fw-bold mb-2">Bersama</h4>
          <p class="text-muted mb-0">Wujudkan sekolah yang lebih baik, unggul, dan berkarakter bersama masyarakat.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================
     ALUR SISTEM (Panel 8 Desain)
============================================ -->
<section class="section-pad home-content-section bg-white" id="alur">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 680px;" data-aos="fade-up">
      <span class="eyebrow"><i class="bi bi-signpost-split-fill"></i> Alur Pelayanan</span>
      <h2 class="section-title mt-3">Bagaimana Saran Anda Diproses?</h2>
      <p class="section-sub mx-auto mt-2">Sistem SIPESAN memastikan setiap aspirasi dari pihak eksternal sampai ke unit kerja terkait di SMPN 2 Purwakarta.</p>
    </div>

    <div class="row g-4 justify-content-center text-center">
      <div class="col-md-2 col-6" data-aos="fade-up">
        <div class="p-3 bg-light rounded-4 h-100">
          <div class="p-3 bg-white text-primary rounded-circle shadow-sm mx-auto mb-3" style="width: 60px; height: 60px; display: grid; place-items: center;">
            <i class="bi bi-person-fill fs-3"></i>
          </div>
          <h6 class="fw-bold font-display">Pihak Eksternal</h6>
          <small class="text-muted">Mengirimkan saran secara terbuka / anonim</small>
        </div>
      </div>

      <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center text-muted">
        <i class="bi bi-arrow-right fs-3"></i>
      </div>

      <div class="col-md-2 col-6" data-aos="fade-up" data-aos-delay="100">
        <div class="p-3 bg-light rounded-4 h-100">
          <div class="p-3 bg-white text-success rounded-circle shadow-sm mx-auto mb-3" style="width: 60px; height: 60px; display: grid; place-items: center;">
            <i class="bi bi-cpu-fill fs-3"></i>
          </div>
          <h6 class="fw-bold font-display">Sistem SIPESAN</h6>
          <small class="text-muted">Menyimpan saran &amp; menerbitkan kode unik</small>
        </div>
      </div>

      <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center text-muted">
        <i class="bi bi-arrow-right fs-3"></i>
      </div>

      <div class="col-md-2 col-6" data-aos="fade-up" data-aos-delay="200">
        <div class="p-3 bg-light rounded-4 h-100">
          <div class="p-3 bg-white text-danger rounded-circle shadow-sm mx-auto mb-3" style="width: 60px; height: 60px; display: grid; place-items: center;">
            <i class="bi bi-shield-check fs-3"></i>
          </div>
          <h6 class="fw-bold font-display">Wakasek Humas</h6>
          <small class="text-muted">Memverifikasi &amp; mendisposisi ke bagian terkait</small>
        </div>
      </div>

      <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center text-muted">
        <i class="bi bi-arrow-right fs-3"></i>
      </div>

      <div class="col-md-2 col-6" data-aos="fade-up" data-aos-delay="300">
        <div class="p-3 bg-light rounded-4 h-100">
          <div class="p-3 bg-white text-warning rounded-circle shadow-sm mx-auto mb-3" style="width: 60px; height: 60px; display: grid; place-items: center;">
            <i class="bi bi-clipboard-check fs-3"></i>
          </div>
          <h6 class="fw-bold font-display">Tindak Lanjut</h6>
          <small class="text-muted">Pelaksanaan perbaikan &amp; pembaruan status</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================
     KATEGORI SARAN
============================================ -->
<section class="section-pad home-content-section" id="kategori" style="background: var(--clr-bg);">
  <div class="container">
    <div class="text-center mx-auto mb-5" style="max-width: 680px;" data-aos="fade-up">
      <span class="eyebrow"><i class="bi bi-grid-fill"></i> Kategori Layanan</span>
      <h2 class="section-title mt-3">Bidang Saran Yang Diterima</h2>
      <p class="section-sub mx-auto mt-2">Kami menerima saran dan masukan untuk seluruh bidang operasional di SMPN 2 Purwakarta.</p>
    </div>

    <div class="row g-4">
      @foreach($categories as $cat)
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <div class="card h-100 p-4 border-0 rounded-4 shadow-sm bg-white">
          <div class="d-flex align-items-start gap-3">
            <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 fs-3">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <div>
              <h5 class="font-display fw-bold mb-1">{{ $cat->nama }}</h5>
              <p class="text-muted small mb-0">{{ $cat->deskripsi ?? 'Masukan dan aspirasi seputar ' . $cat->nama }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

@endsection
