import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const applyAosToElements = () => {
    document.querySelectorAll('body *').forEach((element) => {
        if (element.hasAttribute('data-aos')) {
            return;
        }

        element.setAttribute('data-aos', 'fade-up');
    });
};

window.addEventListener('load', () => {
    if (!window.AOS) {
        return;
    }

    applyAosToElements();
    window.AOS.init({
        once: true,
        duration: 700,
        easing: 'ease-out-cubic',
    });
    window.AOS.refreshHard();
});
