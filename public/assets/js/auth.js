/* 
========================================================================
   BOOTSTRAP 5 ADMIN TEMPLATE - SPARK ADMIN
   AUTHENTICATION MODULE JAVASCRIPT
   Developed with premium UI/UX standards

   Template Name: Spark Admin
   Version: 1.0 
   Author: Spark Admin Team 
   Email: hello.sparkadmin@gmail.com
   URL: https://sparkadmin.web.id
========================================================================
*/

document.addEventListener('DOMContentLoaded', function () {
    // Bersihkan residu penyimpanan username jika ada dari sesi sebelumnya
    try {
        localStorage.removeItem('sipesan_remember_username');
    } catch (e) {
        // Abaikan error pada environment strict
    }

    /**
     * Password Visibility Toggle Logic
     * Enables toggling password input between obscured dots and plain text.
     */
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const usernameInput = document.getElementById('username') || document.getElementById('email');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            // Toggle input type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon class & aria-label
            const icon = this.querySelector('i');
            if (type === 'text') {
                if (icon) {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
                this.setAttribute('aria-label', 'Hide password');
            } else {
                if (icon) {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
                this.setAttribute('aria-label', 'Show password');
            }
        });

        // Apabila halaman dimuat dengan status error kata sandi, kosongkan dan fokuskan kembali ke input kata sandi
        const passwordGroup = passwordInput.closest('.login-input-group');
        if (passwordGroup && passwordGroup.classList.contains('border-danger')) {
            passwordInput.value = '';
            setTimeout(function () {
                passwordInput.focus();
            }, 50);
        }

        // Real-time listener: bersihkan status error ketika sudah 8 karakter atau lebih
        passwordInput.addEventListener('input', function () {
            const clientFeedback = document.getElementById('password-client-feedback');
            if (this.value.length >= 8) {
                if (clientFeedback) clientFeedback.remove();
                const group = this.closest('.login-input-group');
                if (group) {
                    group.style.borderColor = '';
                    group.classList.remove('border-danger', 'shake-animation');
                    const icon = group.querySelector('.input-icon');
                    if (icon) icon.classList.remove('text-danger');
                }
            }
        });
    }

    /**
     * Form Submission & Button Feedback Logic
     * Validasi minimal 8 huruf/karakter pada kata sandi sebelum form dikirim.
     */
    const loginForm = document.getElementById('loginForm');
    const btnSubmit = document.getElementById('btn-submit');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const userInput = document.getElementById('username') || document.getElementById('email');
            const passInput = document.getElementById('password');

            if (!userInput || !passInput || !userInput.value.trim() || !passInput.value) {
                return;
            }

            // Validasi minimal 8 huruf / karakter kata sandi
            if (passInput.value.length < 8) {
                e.preventDefault();
                passInput.focus();

                let clientFeedback = document.getElementById('password-client-feedback');
                if (!clientFeedback) {
                    clientFeedback = document.createElement('div');
                    clientFeedback.id = 'password-client-feedback';
                    clientFeedback.className = 'text-danger mt-1 d-flex align-items-center';
                    clientFeedback.style.fontSize = '0.8rem';
                    clientFeedback.style.fontWeight = '500';
                    clientFeedback.innerHTML = '<i class="bi bi-x-circle-fill me-1"></i> Kata sandi minimal 8 karakter.';
                    
                    const formGroup = passInput.closest('.login-form-group');
                    if (formGroup) {
                        formGroup.appendChild(clientFeedback);
                    }
                }

                const group = passInput.closest('.login-input-group');
                if (group) {
                    group.style.borderColor = '#ef4444';
                    group.classList.add('border-danger');
                    group.classList.remove('shake-animation');
                    // Trigger reflow to restart animation
                    void group.offsetWidth;
                    group.classList.add('shake-animation');
                    const icon = group.querySelector('.input-icon');
                    if (icon) icon.classList.add('text-danger');
                }
                return;
            }

            if (btnSubmit) {
                btnSubmit.style.opacity = '0.85';
                btnSubmit.style.pointerEvents = 'none';
                btnSubmit.innerHTML = '<span>Memproses...</span> <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>';
            }
        });
    }
});
