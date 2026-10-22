@extends('layouts.user')

@section('title', 'Form Saran - SMPN 2 Purwakarta')

@section('content')
<div class="py-5" style="background: var(--clr-bg); min-height: 85vh;">
  <div class="container" style="max-width: 820px;">

    <!-- Breadcrumb & Header Sesuai Desain Panel 2 -->
    <div class="mb-4 text-center" data-aos="fade-down">
      <h2 class="font-display fw-bold mb-2">Form Saran</h2>
      <p class="text-muted">Silakan isi form berikut untuk menyampaikan saran, kritik, atau masukan Anda.</p>
    </div>

    @if(isset($errors) && $errors->any())
      <div class="alert alert-danger rounded-4 shadow-sm mb-4" role="alert">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Mohon lengkapi formulir dengan benar:</div>
        <ul class="mb-0 ps-3 small">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('user.saran.store') }}" method="POST" enctype="multipart/form-data" id="formSaran" class="needs-validation" novalidate>
      @csrf

      <!-- Form Input Saran -->
      <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 mb-4 bg-white" data-aos="fade-up" data-aos-delay="100">
        <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
          <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 fs-5">
            <i class="bi bi-chat-quote-fill"></i>
          </div>
          <div>
            <h5 class="font-display fw-bold mb-0">Sampaikan Saran</h5>
            <small class="text-muted">Isi detail saran, kritik, atau usulan perbaikan Anda untuk SMPN 2 Purwakarta</small>
          </div>
        </div>

        <div class="row g-3">
          <!-- Data Pengirim (Opsional) -->
          <div class="col-md-6">
            <label class="form-label small fw-semibold" for="nama_pengirim">
              Nama Pengirim <span class="badge bg-light text-muted fw-normal ms-1 border">Opsional</span>
            </label>
            <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control form-control-hw"
                   placeholder="Kosongkan jika ingin anonim"
                   value="{{ old('nama_pengirim') }}">
            <div class="form-text small text-muted">Boleh dikosongkan jika tidak ingin mencantumkan nama.</div>
          </div>

          <div class="col-md-6">
            <label class="form-label small fw-semibold" for="status_pengirim">
              Kategori Pengirim <span class="badge bg-light text-muted fw-normal ms-1 border">Opsional</span>
            </label>
            <select name="status_pengirim" id="status_pengirim" class="form-select form-control-hw">
              <option value="" selected>Pilih kategori pengirim (Opsional)...</option>
              <option value="Orang Tua/Wali" {{ old('status_pengirim') == 'Orang Tua/Wali' ? 'selected' : '' }}>Orang Tua/Wali</option>
              <option value="Siswa" {{ old('status_pengirim') == 'Siswa' ? 'selected' : '' }}>Siswa</option>
              <option value="Alumni" {{ old('status_pengirim') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
              <option value="Masyarakat" {{ old('status_pengirim') == 'Masyarakat' ? 'selected' : '' }}>Masyarakat Umum</option>
              <option value="Komite Sekolah" {{ old('status_pengirim') == 'Komite Sekolah' ? 'selected' : '' }}>Komite Sekolah</option>
              <option value="Instansi" {{ old('status_pengirim') == 'Instansi' ? 'selected' : '' }}>Instansi / Lembaga</option>
              <option value="Lainnya" {{ old('status_pengirim') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            <div class="form-text small text-muted">Pilih hubungan/status Anda dengan sekolah.</div>
          </div>

          <!-- Kategori Saran -->
          <div class="col-12">
            <label class="form-label small fw-semibold" for="category_id">
              Kategori Saran <span class="text-danger">*</span>
            </label>
            <select name="category_id" id="category_id" class="form-select form-control-hw" required>
              <option value="" disabled selected>Pilih kategori saran...</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Judul Saran -->
          <div class="col-12">
            <label class="form-label small fw-semibold" for="judul">
              Judul Saran <span class="text-danger">*</span>
            </label>
            <input type="text" name="judul" id="judul" class="form-control form-control-hw"
                   placeholder="Contoh: Peningkatan fasilitas toilet sekolah"
                   value="{{ old('judul') }}" required>
          </div>

          <!-- Isi Saran -->
          <div class="col-12">
            <label class="form-label small fw-semibold" for="isi">
              Isi Saran <span class="text-danger">*</span>
            </label>
            <textarea name="isi" id="isi" class="form-control form-control-hw" rows="5"
                      placeholder="Tulis saran, kritik, atau masukan Anda di sini secara jelas..." required>{{ old('isi') }}</textarea>
          </div>

          <!-- Lampiran (opsional) -->
          <div class="col-12">
            <label class="form-label small fw-semibold" for="lampiran">
              Lampiran (opsional)
            </label>
            <input type="file" name="lampiran" id="lampiran" class="form-control form-control-hw" accept=".jpg,.jpeg,.png,.pdf">
            <div class="form-text small text-muted">
              Format: JPG, PNG, PDF (maksimal ukuran: 5MB).
            </div>
          </div>
        </div>

        <!-- Tombol Submit Sesuai Desain Mockup -->
        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
          <button type="submit" class="btn-hw-primary px-4 py-2" id="btnSubmitSaran">
            <span>Kirim Saran</span>
            <i class="bi bi-send-fill ms-1"></i>
          </button>
        </div>
      </div>

    </form>

  </div>
</div>
@endsection
