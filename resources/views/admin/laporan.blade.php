@extends('layouts.app')

@section('title', 'Laporan & Rekap Saran - Wakasek Humas')

@push('styles')
<style>
  /* STYLES KHUSUS CETAK / PRINT */
  @media print {
    @page {
      size: A4 landscape;
      margin: 12mm 15mm 15mm 15mm;
    }

    /* Sembunyikan elemen UI website */
    .d-print-none,
    .sidebar-wrapper,
    .navbar-custom,
    .footer-custom,
    .page-header,
    .btn,
    nav,
    header,
    footer {
      display: none !important;
    }

    /* Reset Wrapper agar cetak murni dari pojok dokumen */
    html, body {
      background: #ffffff !important;
      color: #000000 !important;
      font-family: "Times New Roman", Times, serif, sans-serif !important;
      font-size: 10.5pt !important;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }

    .main-wrapper {
      margin-left: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }

    .content-area {
      padding: 0 !important;
      margin: 0 !important;
    }

    .report-card {
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
      margin: 0 !important;
      background: transparent !important;
    }

    /* Kop Surat Cetak */
    .kop-surat {
      border-bottom: 3px double #000000 !important;
      padding-bottom: 10px !important;
      margin-bottom: 16px !important;
    }

    /* Tabel Laporan */
    .table {
      width: 100% !important;
      border-collapse: collapse !important;
      margin-bottom: 16px !important;
    }

    .table th,
    .table td {
      border: 1px solid #000000 !important;
      padding: 5px 7px !important;
      font-size: 9pt !important;
      color: #000000 !important;
      background-color: transparent !important;
      vertical-align: top !important;
    }

    .table thead th {
      background-color: #f2f2f2 !important;
      font-weight: bold !important;
      text-align: center !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* Area Tanda Tangan */
    .signature-area {
      display: block !important;
      page-break-inside: avoid !important;
      margin-top: 25px !important;
    }

    tr {
      page-break-inside: avoid !important;
    }
  }

  /* Style Tampilan Layar Web */
  .kop-surat {
    border-bottom: 3px double #333;
    padding-bottom: 12px;
  }
  .kop-instansi {
    line-height: 1.25;
  }
</style>
@endpush

@section('content')
<!-- Tombol & Header Halaman (Hanya Tampil di Web) -->
<div class="page-header d-print-none">
  <div>
    <h1 class="page-title">Laporan &amp; Rekap Saran</h1>
    <p class="page-subtitle">Rekapitulasi dan cetak laporan penanganan saran pihak eksternal SMPN 2 Purwakarta.</p>
  </div>
  <div class="d-flex gap-2">
    <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" onclick="window.print()">
      <i class="bi bi-printer-fill me-1"></i> Cetak Laporan
    </button>
  </div>
</div>

<!-- Filter Bar (Hanya Tampil di Web) -->
<div class="card border-0 shadow-sm p-4 mb-4 bg-white d-print-none">
  <form action="{{ route('admin.laporan.index') }}" method="GET">
    <div class="row g-3 align-items-end">
      
      <div class="col-md-3">
        <label class="form-label small fw-semibold">Dari Tanggal</label>
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
      </div>

      <div class="col-md-3">
        <label class="form-label small fw-semibold">Sampai Tanggal</label>
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
      </div>

      <div class="col-md-3">
        <label class="form-label small fw-semibold">Status</label>
        <select name="status" class="form-select">
          <option value="">Semua Status</option>
          <option value="Baru" {{ request('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
          <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
          <option value="Sedang Diverifikasi" {{ request('status') == 'Sedang Diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
          <option value="Dalam Proses Tindak Lanjut" {{ request('status') == 'Dalam Proses Tindak Lanjut' ? 'selected' : '' }}>Dalam Proses Tindak Lanjut</option>
          <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
          <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-funnel me-1"></i> Terapkan Filter
        </button>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-light border" title="Reset">
          <i class="bi bi-arrow-repeat"></i>
        </a>
      </div>

    </div>
  </form>
</div>

<!-- Printable Report Container -->
<div class="card border-0 shadow-sm p-4 bg-white report-card">
  
  <!-- KOP SURAT & JUDUL DOKUMEN RESMI (HANYA MUNCUL SAAT CETAK LAPORAN) -->
  <div class="d-none d-print-block">
    <div class="kop-surat mb-3">
      <div class="d-flex align-items-center justify-content-center gap-3">
        <img src="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}" alt="Logo SMPN 2 Purwakarta" style="width: 75px; height: 75px; object-fit: contain;">
        <div class="text-center kop-instansi">
          <div class="fw-bold" style="font-size: 13pt; letter-spacing: 0.5px;">PEMERINTAH KABUPATEN PURWAKARTA</div>
          <div class="fw-bold" style="font-size: 12pt; letter-spacing: 0.5px;">DINAS PENDIDIKAN</div>
          <div class="fw-bold" style="font-size: 15pt; letter-spacing: 1px;">SMP NEGERI 2 PURWAKARTA</div>
          <div class="small" style="font-size: 9pt;">Jl. Jenderal Sudirman No. 31, Nagri Kaler, Kec. Purwakarta, Kab. Purwakarta, Jawa Barat 41115</div>
        </div>
      </div>
    </div>

    <!-- JUDUL DOKUMEN LAPORAN -->
    <div class="text-center my-3">
      <h5 class="fw-bold text-uppercase mb-1" style="letter-spacing: 0.5px;">LAPORAN REKAPITULASI PELAYANAN SARAN &amp; ASPIRASI EKSTERNAL (SIPESAN)</h5>
      <div class="small text-muted">
        @if(request('start_date') && request('end_date'))
          Periode: {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}
        @elseif(request('start_date'))
          Periode Mulai: {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }}
        @elseif(request('end_date'))
          Periode Hingga: {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}
        @else
          Periode: Seluruh Data
        @endif
        @if(request('status'))
          &bull; Filter Status: <strong>{{ request('status') }}</strong>
        @endif
      </div>
    </div>
  </div>

  <!-- TABEL REKAPITULASI LAPORAN (TAMPILAN WEB DENGAN PAGINASI) -->
  <div class="d-print-none">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 40px;" class="text-center">No</th>
            <th style="width: 100px;">Kode</th>
            <th style="width: 85px;">Tanggal</th>
            <th style="width: 140px;">Pengirim</th>
            <th style="width: 110px;">Kategori</th>
            <th>Judul &amp; Ringkasan Saran</th>
            <th style="width: 140px;">Tindak Lanjut</th>
            <th style="width: 100px;" class="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sarans as $idx => $s)
          <tr>
            <td class="text-center">{{ $sarans->firstItem() + $idx }}</td>
            <td><strong>{{ $s->kode_saran }}</strong></td>
            <td class="small">{{ $s->created_at->format('d/m/Y') }}</td>
            <td>
              <div class="fw-bold">{{ $s->nama_tampilan }}</div>
              <div class="text-muted small">({{ $s->status_pengirim }})</div>
            </td>
            <td><span class="small">{{ $s->category->nama ?? '-' }}</span></td>
            <td>
              <div class="fw-semibold">{{ $s->judul }}</div>
              <div class="small text-secondary">{{ Str::limit($s->isi, 90) }}</div>
            </td>
            <td class="small">
              @if($s->ditujukan_kepada)
                <strong>Kepada:</strong> {{ $s->ditujukan_kepada }}<br>
              @endif
              {{ $s->catatan_tindak_lanjut ?? '-' }}
            </td>
            <td class="text-center">
              {{ $s->status }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">Tidak ada data saran pada periode ini.</td>
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

  <!-- TABEL KHUSUS CETAK DOKUMEN (MENCETAK SELURUH DATA HASIL FILTER) -->
  <div class="d-none d-print-block">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th style="width: 40px;" class="text-center">No</th>
          <th style="width: 100px;">Kode</th>
          <th style="width: 85px;">Tanggal</th>
          <th style="width: 140px;">Pengirim</th>
          <th style="width: 110px;">Kategori</th>
          <th>Judul &amp; Ringkasan Saran</th>
          <th style="width: 140px;">Tindak Lanjut</th>
          <th style="width: 100px;" class="text-center">Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($allSarans as $idx => $s)
        <tr>
          <td class="text-center">{{ $idx + 1 }}</td>
          <td><strong>{{ $s->kode_saran }}</strong></td>
          <td class="small">{{ $s->created_at->format('d/m/Y') }}</td>
          <td>
            <div class="fw-bold">{{ $s->nama_tampilan }}</div>
            <div class="text-muted small">({{ $s->status_pengirim }})</div>
          </td>
          <td><span class="small">{{ $s->category->nama ?? '-' }}</span></td>
          <td>
            <div class="fw-semibold">{{ $s->judul }}</div>
            <div class="small text-secondary">{{ Str::limit($s->isi, 90) }}</div>
          </td>
          <td class="small">
            @if($s->ditujukan_kepada)
              <strong>Kepada:</strong> {{ $s->ditujukan_kepada }}<br>
            @endif
            {{ $s->catatan_tindak_lanjut ?? '-' }}
          </td>
          <td class="text-center">
            {{ $s->status }}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center py-4 text-muted">Tidak ada data saran pada periode ini.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- RINGKASAN DATA -->
  <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small text-muted">
    <div><strong>Total Saran:</strong> {{ $allSarans->count() }} Data</div>
    <div>
      <strong>Selesai:</strong> {{ $allSarans->where('status', 'Selesai')->count() }} &bull; 
      <strong>Diproses:</strong> {{ $allSarans->whereIn('status', ['Dalam Proses Tindak Lanjut', 'Sedang Diverifikasi', 'Diterima'])->count() }} &bull;
      <strong>Baru:</strong> {{ $allSarans->where('status', 'Baru')->count() }} &bull;
      <strong>Ditolak:</strong> {{ $allSarans->where('status', 'Ditolak')->count() }}
    </div>
  </div>

  <!-- BAGIAN TANDA TANGAN (HANYA MUNCUL SAAT CETAK LAPORAN) -->
  <div class="signature-area d-none d-print-block mt-4 pt-3">
    <div class="d-flex justify-content-between text-center" style="font-size: 10pt;">
      <div style="width: 280px;">
        <p class="mb-1">&nbsp;</p>
        <p class="fw-bold mb-0">Mengetahui,</p>
        <p class="fw-bold mb-0">Kepala SMP Negeri 2 Purwakarta</p>
        <div style="height: 65px;"></div>
        <p class="fw-bold mb-0 text-decoration-underline">(........................................................)</p>
        <p class="text-muted small mb-0">NIP. ....................................................</p>
      </div>

      <div style="width: 280px;">
        <p class="mb-1">Purwakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p class="fw-bold mb-0">Pengelola Layanan,</p>
        <p class="fw-bold mb-0">Wakasek Bidang Humas</p>
        <div style="height: 65px;"></div>
        <p class="fw-bold mb-0 text-decoration-underline">(........................................................)</p>
        <p class="text-muted small mb-0">NIP. ....................................................</p>
      </div>
    </div>
  </div>

</div>
@endsection
