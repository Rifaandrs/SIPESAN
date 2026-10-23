document.addEventListener('DOMContentLoaded', function () {
    var root = document.documentElement;
    var toggleButtons = document.querySelectorAll('[data-theme-toggle]');

    function setTheme(theme) {
        root.dataset.theme = theme;

        toggleButtons.forEach(function (button) {
            var isDark = theme === 'dark';
            var label = isDark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap';
            var icon = button.querySelector('[data-theme-icon]');

            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);

            if (icon) {
                icon.classList.toggle('bi-sun', isDark);
                icon.classList.toggle('bi-moon-stars', !isDark);
            }
        });
    }

    setTheme(root.dataset.theme === 'dark' ? 'dark' : 'light');

    toggleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
            setTheme(theme);

            try {
                localStorage.setItem('sipesan-theme', theme);
            } catch (error) {
                console.warn('Preferensi tema tidak dapat disimpan.', error);
            }
        });
    });
});
