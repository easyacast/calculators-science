import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Floating share buttons - visible only in main content area, vanish near header/footer
window.shareButtons = function() {
    return {
        visible: false,
        copied: false,
        pageUrl: window.location.href,
        pageTitle: document.title,

        init() {
            const main = document.getElementById('main-content');
            if (!main) return;

            const check = () => {
                const rect = main.getBoundingClientRect();
                const headerClearance = 120;
                const footerClearance = 120;
                this.visible = rect.top < (window.innerHeight - footerClearance) && rect.bottom > headerClearance;
            };

            window.addEventListener('scroll', check, { passive: true });
            check();
        },

        copyLink() {
            navigator.clipboard.writeText(this.pageUrl).then(() => {
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2000);
            });
        },
    };
};

// Delay start so page-specific modules (loaded via @yield('head'))
// can register their components before Alpine processes the DOM.
setTimeout(() => Alpine.start(), 0);
