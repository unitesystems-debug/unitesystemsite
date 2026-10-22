import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('testimonialCarousel', (total) => ({
        active: 0,
        total,
        next() {
            this.active = (this.active + 1) % this.total;
        },
        prev() {
            this.active = (this.active - 1 + this.total) % this.total;
        },
        go(i) {
            this.active = i;
        },
    }));
});

Alpine.start();

// Reveal elements marked [data-animate] (fade + rise) or [data-animate-line]
// (grow left-to-right) once they scroll into view.
function initScrollReveal() {
    const items = document.querySelectorAll('[data-animate], [data-animate-line]');
    if (!items.length) return;

    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('in-view'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    items.forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', initScrollReveal);
