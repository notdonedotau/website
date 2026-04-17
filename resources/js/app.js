const root = document.documentElement;
const toggle = document.querySelector('[data-theme-toggle]');

if (toggle) {
    const label = toggle.querySelector('.theme-toggle__label');
    const getTheme = () => root.dataset.theme === 'dark' ? 'dark' : 'light';

    const syncToggle = () => {
        const isDark = getTheme() === 'dark';

        toggle.setAttribute('aria-pressed', String(isDark));
        if (label) {
            label.textContent = isDark ? 'Light mode' : 'Dark mode';
        }
    };

    toggle.addEventListener('click', () => {
        const nextTheme = getTheme() === 'dark' ? 'light' : 'dark';

        root.dataset.theme = nextTheme;
        localStorage.setItem('theme', nextTheme);
        syncToggle();
    });

    syncToggle();
}
