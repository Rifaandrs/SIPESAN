@extends('layouts.user')

@section('title', 'Cek Status Saran - SIPESAN')

@section('content')
<div class="py-5" style="background: var(--clr-bg); min-height: 85vh;">
  <div class="container" style="max-width: 960px;">

    <!-- Header Sesuai Desain Panel 4 -->
    <div class="text-center mb-4" data-aos="fade-down">
      <h2 class="font-display fw-bold mb-2">Cek Status Saran</h2>
      <p class="text-muted">Masukkan kode saran Anda untuk melihat perkembangan tindak lanjut.</p>
    </div>

    <!-- Search Box Sesuai Desain Panel 4 -->
    <div class="card border-0 rounded-4 shadow-sm p-4 p-md-4 mb-4 bg-white" data-aos="fade-up">
      <form action="{{ route('user.saran.status') }}" method="GET" id="formCekStatus">
        <div class="row g-2">
          <div class="col-md-9">
            <div class="input-group">
              <span class="input-group-text bg-light border-0 ps-3">
                <i class="bi bi-search text-muted"></i>
              </span>
              <input type="text" name="kode" id="inputKodeSaran" class="form-control form-control-hw ps-2" 
                     placeholder="Contoh: SPN-2026-00125" 
                     value="{{ $kode }}" autofocus>
              @if(!empty($kode))
                <a href="{{ route('user.saran.status') }}" class="input-group-text bg-light border-0 pe-3 text-muted" title="Bersihkan dan tampilkan semua saran">
                  <i class="bi bi-x-circle-fill"></i>
                </a>
              @endif
            </div>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn-hw-primary w-100 justify-content-center py-2">
              <span>Cek Status</span>
            </button>
          </div>
        </div>
      </form>
    </div>

    @if($searched)
      @if($saran)
        <!-- Hasil Pelacakan Sesuai Desain Panel 4 -->
        <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white mb-4" data-aos="fade-up">
          
          <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 pb-3 mb-4 border-bottom">
            <div>
              <span class="text-muted small text-uppercase fw-semibold">Kode Saran</span>
              <h4 class="font-display fw-bold mb-1 text-primary">{{ $saran->kode_saran }}</h4>
              <h5 class="fw-bold mb-1">{{ $saran->judul }}</h5>
              <div class="text-muted small">
                Kategori: <strong>{{ $saran->category->nama ?? '-' }}</strong> &bull;
                Pengirim: <strong>{{ $saran->nama_tampilan }}</strong> ({{ $saran->status_pengirim }})
              </div>
            </div>
            <div>
              <span class="badge rounded-pill px-3 py-2 fs-6 {{ $saran->status_badge_class }}">
                {{ $saran->status }}
              </span>
            </div>
          </div>

          <!-- Detail Data Saran (Isi Saran & Lampiran) -->
          <div class="p-3 p-md-4 rounded-4 bg-light border mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-6">
                <i class="bi bi-chat-quote-fill"></i>
              </div>
              <h6 class="fw-bold font-display text-primary mb-0">Isi Saran / Aspirasi</h6>
            </div>
            <div class="text-dark my-3 p-3 bg-white rounded-3 border" style="white-space: pre-line; line-height: 1.6;">{{ $saran->isi }}</div>

            <div class="row g-2 pt-2 border-top small text-muted">
              <div class="col-sm-6">
                <i class="bi bi-calendar3 me-1"></i> Tanggal Kirim: <strong>{{ $saran->created_at->format('d M Y, H:i') }} WIB</strong>
              </div>
              @if($saran->lampiran)
                <div class="col-sm-6 text-sm-end">
                  <a href="{{ asset($saran->lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="bi bi-paperclip me-1"></i> Buka Lampiran Berkas
                  </a>
                </div>
              @endif
            </div>
          </div>

          <!-- Vertical Stepper Timeline Sesuai Desain Mockup Panel 4 -->
          <h6 class="fw-bold font-display mb-3">Status Saran</h6>

          @php
            $steps = [
              'Saran Dikirim' => 'Saran telah berhasil dikirimkan oleh pengirim.',
              'Saran Diterima' => 'Saran diterima oleh tim Humas sekolah.',
              'Sedang Diverifikasi' => 'Saran sedang diverifikasi dan ditinjau kelayakannya.',
              'Dalam Proses Tindak Lanjut' => 'Saran sedang dalam pelaksanaan tindak lanjut oleh unit terkait.',
              'Selesai' => 'Saran telah selesai ditindaklanjuti secara tuntas.',
            ];

            // Tentukan index step aktif
            $statusMapping = [
              'Baru' => 0,
              'Saran Dikirim' => 0,
              'Diterima' => 1,
              'Saran Diterima' => 1,
              'Sedang Diverifikasi' => 2,
              'Dalam Proses Tindak Lanjut' => 3,
              'Selesai' => 4,
              'Ditolak' => -1,
            ];

            $currentIndex = $statusMapping[$saran->status] ?? 0;
            $stepKeys = array_keys($steps);
          @endphp

          @if($saran->status === 'Ditolak')
            <div class="alert alert-danger rounded-3 p-3 mb-4">
              <i class="bi bi-x-circle-fill me-2"></i> <strong>Saran Ditolak:</strong> 
              {{ $saran->catatan_tindak_lanjut ?? 'Saran tidak dapat diproses lebih lanjut setelah peninjauan.' }}
            </div>
          @endif

          <div class="timeline-stepper ps-3 mb-4 position-relative" style="border-left: 2px solid #e2e8f0; margin-left: 12px;">
            @foreach($stepKeys as $idx => $stepName)
              @php
                $isCompleted = ($currentIndex >= $idx && $saran->status !== 'Ditolak');
                $isCurrent = ($currentIndex === $idx && $saran->status !== 'Ditolak');
                $historyRecord = $saran->histories->where('status', $stepName)->first();
              @endphp

              <div class="position-relative pb-4 ps-4">
                <!-- Icon Bullet -->
                <div class="position-absolute" style="left: -11px; top: 0;">
                  @if($isCompleted)
                    <span class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 20px; height: 20px; font-size: 0.65rem;">
                      <i class="bi bi-check-lg"></i>
                    </span>
                  @elseif($isCurrent)
                    <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 20px; height: 20px; font-size: 0.65rem;">
                      <i class="bi bi-dot fs-5"></i>
                    </span>
                  @else
                    <span class="rounded-circle bg-secondary bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
                    </span>
                  @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="mb-0 fw-bold {{ $isCompleted || $isCurrent ? 'text-dark' : 'text-muted' }}">
                    {{ $stepName }}
                  </h6>
                  @if($historyRecord)
                    <small class="text-muted" style="font-size: 0.75rem;">
                      {{ $historyRecord->created_at->format('d M Y, H:i') }}
                    </small>
                  @endif
                </div>
                <p class="small text-muted mb-0">
                  {{ $historyRecord->catatan ?? $steps[$stepName] }}
                </p>
              </div>
            @endforeach
          </div>

          <!-- Catatan Tindak Lanjut dari Wakasek Humas -->
          @if($saran->catatan_tindak_lanjut || $saran->ditujukan_kepada)
            <div class="p-3 bg-light rounded-3 border">
              <h6 class="fw-bold font-display mb-2 text-primary">
                <i class="bi bi-clipboard-check-fill me-1"></i> Informasi Tindak Lanjut dari Sekolah
              </h6>
              @if($saran->ditujukan_kepada)
                <div class="small mb-1">
                  <strong>Ditujukan Kepada:</strong> {{ $saran->ditujukan_kepada }}
                </div>
              @endif
              @if($saran->catatan_tindak_lanjut)
                <div class="small">
                  <strong>Catatan Humas:</strong> {{ $saran->catatan_tindak_lanjut }}
                </div>
              @endif
            </div>
          @endif

        </div>
      @else
        <!-- Jika Tidak Ditemukan -->
        <div class="card border-0 rounded-4 shadow-sm p-5 text-center bg-white" data-aos="fade-up">
          <div class="text-warning mb-3" style="font-size: 3rem;">
            <i class="bi bi-question-circle"></i>
          </div>
          <h4 class="font-display fw-bold mb-2">Kode Saran Tidak Ditemukan</h4>
          <p class="text-muted mb-4">
            Tidak ditemukan data saran dengan kode <strong>"{{ $kode }}"</strong>.<br>
            Pastikan Anda memasukkan kode saran yang benar (Contoh: <code>SPN-2026-00125</code>).
          </p>
          <div>
            <a href="{{ route('user.saran.create') }}" class="btn-hw-primary">
              <i class="bi bi-pencil-square me-1"></i> Sampaikan Saran Baru
            </a>
          </div>
        </div>
      @endif
    @endif

    {{-- =========================================================
         PAPAN DATA SARAN MASUK
    ========================================================= --}}
    <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white mb-4" data-aos="fade-up">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
          <h5 class="font-display fw-bold mb-1">
            <i class="bi bi-inbox-fill text-primary me-2"></i>Data Saran Masuk
          </h5>
          <p class="text-muted small mb-0">Daftar aspirasi dan saran yang telah disampaikan kepada pihak SMPN 2 Purwakarta.</p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
          {{ $allSarans->total() }} Saran Masuk
        </span>
      </div>

      @if($allSarans->count() > 0)
        <div class="table-responsive">
          <table class="table align-middle table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="small fw-semibold text-muted" style="width: 140px;">Tanggal</th>
                <th class="small fw-semibold text-muted" style="width: 150px;">Kode Saran</th>
                <th class="small fw-semibold text-muted">Judul Saran</th>
                <th class="small fw-semibold text-muted">Kategori</th>
                <th class="small fw-semibold text-muted text-center">Status</th>
                <th class="small fw-semibold text-muted text-center" style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($allSarans as $item)
              <tr>
                <td>
                  <div class="fw-semibold small">{{ $item->created_at->format('d M Y') }}</div>
                  <div class="text-muted" style="font-size: 0.78rem;">{{ $item->created_at->format('H:i') }} WIB</div>
                </td>
                <td>
                  <strong class="text-primary">{{ $item->kode_saran }}</strong>
                </td>
                <td>
                  <div class="fw-semibold small">{{ $item->judul }}</div>
                  <div class="text-muted" style="font-size: 0.78rem;">
                    {{ $item->nama_tampilan }} ({{ $item->status_pengirim }})
                  </div>
                </td>
                <td>
                  <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                    {{ $item->category->nama ?? '-' }}
                  </span>
                </td>
                <td class="text-center">
                  <span class="badge rounded-pill px-3 py-1 {{ $item->status_badge_class }}" style="font-size: 0.75rem;">
                    {{ $item->status }}
                  </span>
                </td>
                <td class="text-center">
                  <a href="{{ route('user.saran.status', ['kode' => $item->kode_saran]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: 0.78rem;" title="Lihat Status">
                    <i class="bi bi-search me-1"></i> Cek
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if($allSarans->hasPages())
          <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3 border-top small text-muted">
            <div>Menampilkan {{ $allSarans->firstItem() }} sampai {{ $allSarans->lastItem() }} dari {{ $allSarans->total() }} saran</div>
            <div>{{ $allSarans->appends(['kode' => $kode])->links() }}</div>
          </div>
        @endif
      @else
        <div class="text-center py-5 text-muted">
          <i class="bi bi-inbox fs-1 mb-3 d-block opacity-50"></i>
          <p class="mb-0">Belum ada saran yang masuk.</p>
        </div>
      @endif
    </div>

  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const inputKode = document.getElementById('inputKodeSaran');
    const formCekStatus = document.getElementById('formCekStatus');
    const isSearched = {{ $searched ? 'true' : 'false' }};

    if (inputKode) {
      // Jika sebelumnya sedang menampilkan hasil pencarian dan user menghapus teks sampai kosong, otomatis refresh
      inputKode.addEventListener('input', function () {
        if (isSearched && this.value.trim() === '') {
          window.location.href = "{{ route('user.saran.status') }}";
        }
      });
    }

    if (formCekStatus) {
      formCekStatus.addEventListener('submit', function (e) {
        if (inputKode && inputKode.value.trim() === '') {
          e.preventDefault();
          window.location.href = "{{ route('user.saran.status') }}";
        }
      });
    }
  });
</script>
@endpush
@endsection
