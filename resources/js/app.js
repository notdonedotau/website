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

const pricingPeriodButtons = document.querySelectorAll('[data-pricing-period]');
const pricingOrderLinks = document.querySelectorAll('[data-monthly-url][data-annual-url]');
const pricingPrices = document.querySelectorAll('[data-monthly-price][data-annual-price]');

if (pricingPeriodButtons.length > 0) {
    const syncPricingPeriod = (period) => {
        const isAnnual = period === 'annual';

        pricingPeriodButtons.forEach((button) => {
            const isActive = button.dataset.pricingPeriod === period;

            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-pressed', String(isActive));
        });

        pricingOrderLinks.forEach((link) => {
            link.href = isAnnual ? link.dataset.annualUrl : link.dataset.monthlyUrl;
        });

        pricingPrices.forEach((price) => {
            const value = price.querySelector('[data-pricing-price]');
            const suffix = price.querySelector('[data-pricing-suffix]');

            if (value && suffix) {
                value.textContent = isAnnual ? price.dataset.annualPrice : price.dataset.monthlyPrice;
                suffix.textContent = isAnnual ? price.dataset.annualSuffix : price.dataset.monthlySuffix;
            }
        });
    };

    pricingPeriodButtons.forEach((button) => {
        button.addEventListener('click', () => {
            syncPricingPeriod(button.dataset.pricingPeriod);
        });
    });
}
