document.addEventListener('DOMContentLoaded', function () {
    var modalElement = document.getElementById('profilePhotoModal');
    var fullPhoto = document.getElementById('fullProfilePhoto');

    if (!modalElement || !fullPhoto || !window.bootstrap) {
        return;
    }

    var modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-profile-photo]');

        if (!trigger) {
            return;
        }

        if (trigger.dataset.suppressPhotoClick === 'true') {
            delete trigger.dataset.suppressPhotoClick;
            event.preventDefault();
            event.stopPropagation();
            return;
        }

        var source = trigger.dataset.photoUrl;
        if (!source) {
            var image = trigger instanceof HTMLImageElement ? trigger : trigger.querySelector('img');
            if (image) {
                source = image.currentSrc || image.src;
            }
        }

        if (!source) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();
        fullPhoto.src = source;
        modal.show();
    });

    modalElement.addEventListener('hidden.bs.modal', function () {
        fullPhoto.removeAttribute('src');
    });
});
