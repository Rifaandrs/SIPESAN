@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-header mb-4">
    <div>
        <h1 class="page-title">Profil Saya</h1>
        <p class="page-subtitle text-muted">Lihat dan edit informasi akun Anda</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- Alert sukses --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Kartu Info Profil --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 d-flex align-items-center gap-4">
                <div class="flex-shrink-0 position-relative">
                    @if($user->photo)
                        <button type="button" class="profile-photo-trigger" data-profile-photo
                            data-photo-url="{{ Storage::url($user->photo) }}" aria-label="Lihat foto profil penuh">
                            <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil"
                                class="profile-avatar-large">
                        </button>
                    @else
                        <img src="{{ asset('assets/images/default-avatar.jpg') }}" alt="Avatar default"
                            class="profile-avatar-large">
                    @endif
                </div>
                <div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    @if($user->photo)
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                            data-bs-toggle="modal" data-bs-target="#deleteProfilePhotoModal">
                            <i class="bi bi-trash me-1"></i> Hapus Foto Profil
                        </button>
                    @else
                        <span class="small text-muted">Belum ada foto profil</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Form Edit Profil --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Informasi Akun</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf

                    {{-- Foto Profil --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="profile-photo-trigger" data-profile-photo
                                id="preview-photo-trigger" aria-label="Lihat foto profil penuh">
                                <img src="{{ $user->photo ? Storage::url($user->photo) : asset('assets/images/default-avatar.jpg') }}"
                                    alt="Pratinjau foto profil" id="preview-img" class="profile-avatar-preview">
                            </button>
                            <div class="flex-grow-1 w-100">
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    id="photo" name="photo" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text">JPG, PNG, atau WEBP. Maks 2MB.</div>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <p class="text-muted small mb-3"><i class="bi bi-info-circle me-1"></i>Kosongkan kolom password jika tidak ingin mengubah password.</p>

                    {{-- Password Baru --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password Baru</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Minimal 8 karakter">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@if($user->photo)
<div class="modal fade" id="deleteProfilePhotoModal" tabindex="-1"
    aria-labelledby="deleteProfilePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-photo-modal rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="deleteProfilePhotoModalLabel">Hapus Foto Profil?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apa Anda yakin ingin menghapus foto profil ini?</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.profile.photo.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Hapus Foto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.getElementById('photo').addEventListener('change', function () {
        const file = this.files && this.files[0];
        const preview = document.getElementById('preview-img');

        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.addEventListener('load', function () {
            preview.src = reader.result;
        });
        reader.readAsDataURL(file);
    });
</script>
@endpush
