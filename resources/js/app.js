const root = document.documentElement;
const toggle = document.querySelector('[data-theme-toggle]');

if (toggle) {
    const getTheme = () => root.dataset.theme === 'dark' ? 'dark' : 'light';

    const syncToggle = () => {
        const isDark = getTheme() === 'dark';

        toggle.setAttribute('aria-pressed', String(isDark));
        toggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    };

    toggle.addEventListener('click', () => {
        const nextTheme = getTheme() === 'dark' ? 'light' : 'dark';

        root.dataset.theme = nextTheme;
        localStorage.setItem('theme', nextTheme);
        syncToggle();
    });

    syncToggle();
}
