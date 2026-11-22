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

    // Auto-advancing, looping image carousel (e.g. the homepage hero).
    // Call start()/stop() to control autoplay (e.g. pause on hover);
    // go(i) jumps to a slide and restarts the timer.
    Alpine.data('heroCarousel', (total, interval) => ({
        active: 0,
        total,
        interval,
        timer: null,
        start() {
            this.stop();
            if (this.total <= 1) return;
            this.timer = setInterval(() => {
                this.active = (this.active + 1) % this.total;
            }, this.interval);
        },
        stop() {
            clearInterval(this.timer);
            this.timer = null;
        },
        go(i) {
            this.active = i;
            this.start();
        },
        destroy() {
            this.stop();
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
