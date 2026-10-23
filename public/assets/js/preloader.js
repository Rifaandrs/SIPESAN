document.addEventListener('DOMContentLoaded', function () {
    var preloader = document.getElementById('preloader');

    if (!preloader) {
        return;
    }

    function hidePreloader() {
        preloader.classList.add('hide');
    }

    window.addEventListener('load', function () {
        setTimeout(hidePreloader, 400);
    }, { once: true });

    setTimeout(hidePreloader, 2500);
});
