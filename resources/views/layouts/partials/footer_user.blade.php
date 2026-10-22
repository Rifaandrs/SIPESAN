<!-- ============================================
     FOOTER (PIHAK EKSTERNAL / USER PUBLIK)
============================================ -->
<footer class="footer-hw">
    <svg class="footer-wave" viewBox="0 0 1440 70" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path fill="#0B1220" d="M0,32 C240,70 480,0 720,18 C960,36 1200,70 1440,26 L1440,70 L0,70 Z"></path>
    </svg>
    <span class="footer-glow"></span>
    <span class="footer-glow-2"></span>
    <div class="container footer-top">
        <div class="row g-2">
            <div class="col-lg-5 col-md-6 pe-md-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="hw-logo-mark"><img src="{{ asset('assets/images/smpn-2-purwakarta-logo.png') }}" alt="Logo SMPN 2 Purwakarta"></span>
                    <div>
                        <span class="d-block text-white fw-bold font-display fs-6">SIPESAN</span>
                        <span class="text-white-50 small" style="font-size: 0.75rem;">SMPN 2 PURWAKARTA</span>
                    </div>
                </div>
                <p class="mt-1 text-white-50 small mb-2" style="font-size: 0.84rem; line-height: 1.45;">Sistem Pelayanan Saran Eksternal SMPN 2 Purwakarta. Bersama membangun sekolah yang lebih baik melalui masukan yang transparan dan akuntabel.</p>
            </div>

            <div class="col-6 col-md-3 col-lg-3">
                <h6>Menu Pelayanan</h6>
                <ul>
                    <li><a class="footer-link small" href="{{ route('user.home') }}"><i class="bi bi-caret-right-fill"></i>Beranda</a></li>
                    <li><a class="footer-link small" href="{{ route('user.saran.create') }}"><i class="bi bi-caret-right-fill"></i>Form Sampaikan Saran</a></li>
                    <li><a class="footer-link small" href="{{ route('user.saran.status') }}"><i class="bi bi-caret-right-fill"></i>Cek Status Saran</a></li>
                    <li><a class="footer-link small" href="{{ route('login') }}"><i class="bi bi-caret-right-fill"></i>Login Petugas Humas</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-4">
                <h6>Kontak Sekolah</h6>
                <div class="footer-contact-item text-white-50">
                    <span class="ic"><i class="bi bi-geo-alt-fill"></i></span>
                    <span>Jl. Veteran Gg. Sawo No.164 (0264) 200202 Kelurahan Ciseureuh Kec/Kab. Purwakarta Kode Pos 41118</span>
                </div>
                <div class="footer-contact-item text-white-50">
                    <span class="ic"><i class="bi bi-envelope-fill"></i></span>
                    <span>smpnpurwakarta02@gmail.com</span>
                </div>
                <div class="footer-contact-item text-white-50">
                    <span class="ic"><i class="bi bi-globe"></i></span>
                    <span>smpn2purwakarta.sch.id</span>
                </div>
                <div class="footer-contact-item text-white-50 align-items-center">
                    <span class="ic"><i class="bi bi-shield-check"></i></span>
                    <span>Dikelola oleh: Wakasek Bidang Hubungan Masyarakat</span>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>
        <div class="footer-bottom text-center">
            <div class="text-white-50 small">&copy; {{ date('Y') }} SIPESAN SMPN 2 Purwakarta. Bersama Membangun Sekolah yang Lebih Baik.</div>
        </div>
    </div>
</footer>

<style>
    /* Kurangi gap/padding section sebelum footer */
    main > section:last-child,
    main > div:last-child {
        padding-bottom: 40px !important;
    }
    .footer-hw {
        padding-top: 0 !important;
        padding-bottom: 14px;
        margin-top: 0 !important;
    }
    .footer-hw .footer-top {
        padding-top: 8px;
    }
    .footer-hw h6 {
        margin-bottom: 12px;
        padding-bottom: 6px;
        font-size: 0.88rem;
    }
    .footer-hw ul li {
        margin-bottom: 0.5rem;
    }
    .footer-contact-item {
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .footer-contact-item .ic {
        width: 30px;
        height: 30px;
        font-size: 0.82rem;
        border-radius: 8px;
    }
    .footer-contact-item span {
        font-size: 0.84rem;
        line-height: 1.35;
    }
    .footer-divider {
        margin: 16px 0 0;
    }
    .footer-bottom {
        padding-top: 10px;
        font-size: 0.82rem;
    }
</style>
