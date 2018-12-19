(function () {
    $('[data-modal-trigger]').on('click', function (e) {
        e.preventDefault();
        $('[data-modal="' + $(this).data('modalTrigger') + '"]').modal('show');
    });
})();
