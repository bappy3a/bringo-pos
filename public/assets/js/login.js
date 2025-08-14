(function () {
    "use strict"
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const dot1 = document.getElementById('dot1');
    const dot2 = document.getElementById('dot2');
    const progress = document.getElementById('progressBar');
    const progressWrap = progress.parentElement;

    function go(step) {
        const to2 = step === 2;
        step1.classList.toggle('hidden', to2);
        step2.classList.toggle('hidden', !to2);
        dot1.className = 'step__dot ' + (to2 ? 'step__dot--muted' : 'step__dot--active');
        dot2.className = 'step__dot ' + (to2 ? 'step__dot--active' : 'step__dot--muted');
        const val = to2 ? 100 : 50;
        progress.style.width = val + '%';
        progressWrap.setAttribute('aria-valuenow', String(val));
        document.getElementById(to2 ? 'h-step2' : 'h-step1').focus({ preventScroll: true });
    }

    document.getElementById('toStep2').addEventListener('click', function () { go(2); });
    document.getElementById('backTo1').addEventListener('click', function () { go(1); });
})();