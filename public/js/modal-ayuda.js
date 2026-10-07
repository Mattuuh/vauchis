(function ($) {
    'use strict';

    const $modal = $('#modalAyuda');
    if (!$modal.length) return;

    let currentStep = 1;
    const totalSteps = 6;
    let personalizeTimer = null;
    let paymentTimer = null;

    function clearStepTimers() {
        if (personalizeTimer) {
            clearInterval(personalizeTimer);
            personalizeTimer = null;
        }

        if (paymentTimer) {
            clearInterval(paymentTimer);
            paymentTimer = null;
        }
    }

    function startPersonalizeCarousel() {
        const $slides = $modal.find('[data-personalize-carousel] .vh-help-personalize__slide');
        let index = 0;

        $slides.removeClass('is-active').eq(0).addClass('is-active');

        personalizeTimer = setInterval(function () {
            index = (index + 1) % $slides.length;
            $slides.removeClass('is-active').eq(index).addClass('is-active');
        }, 2200);
    }

    function startPaymentCarousel() {
        const $slides = $modal.find('[data-payment-carousel] .vh-help-payment__slide');
        let index = 0;

        $slides.removeClass('is-active').eq(0).addClass('is-active');

        paymentTimer = setInterval(function () {
            index = (index + 1) % $slides.length;
            $slides.removeClass('is-active').eq(index).addClass('is-active');
        }, 2000);
    }

    function startCurrentStepAnimation() {
        clearStepTimers();

        if (currentStep === 4) startPersonalizeCarousel();
        if (currentStep === 5) startPaymentCarousel();
    }

    function updateNavigation() {
        const $prev = $modal.find('[data-help-prev]');
        const $nextLabel = $modal.find('[data-help-next-label]');
        const $dots = $modal.find('[data-help-dot]');

        if (currentStep === 1) {
            $prev.attr('hidden', true);
        } else {
            $prev.removeAttr('hidden');
        }

        $nextLabel.text(currentStep === totalSteps ? '¡Listo!' : 'Siguiente');

        $dots.each(function () {
            const step = Number($(this).data('help-dot'));
            $(this)
                .toggleClass('is-active', step === currentStep)
                .toggleClass('is-complete', step < currentStep);
        });
    }

    function showStep(step) {
        currentStep = Math.max(1, Math.min(totalSteps, step));

        $modal.find('.vh-help-step').removeClass('is-active');
        $modal.find('.vh-help-step[data-step="' + currentStep + '"]').addClass('is-active');

        updateNavigation();
        startCurrentStepAnimation();
    }

    $modal.on('click', '[data-help-next]', function () {
        if (currentStep >= totalSteps) {
            const modalInstance = bootstrap.Modal.getOrCreateInstance($modal[0]);
            modalInstance.hide();
            return;
        }

        showStep(currentStep + 1);
    });

    $modal.on('click', '[data-help-prev]', function () {
        showStep(currentStep - 1);
    });

    $modal.on('click', '[data-help-dot]', function () {
        showStep(Number($(this).data('help-dot')));
    });

    $modal.on('shown.bs.modal', function () {
        showStep(1);
    });

    $modal.on('hidden.bs.modal', function () {
        clearStepTimers();
        showStep(1);
    });

    showStep(1);
})(jQuery);
