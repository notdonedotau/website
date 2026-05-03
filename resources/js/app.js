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

const getStartedForm = document.querySelector('[data-get-started-form]');

if (getStartedForm) {
    const statusPageNameInput = getStartedForm.querySelector('[data-status-page-name-input]');
    const statusPageSlugInput = getStartedForm.querySelector('[data-status-page-slug-input]');
    const statusPageSlugOutput = getStartedForm.querySelector('[data-status-page-slug-output]');
    const planOptions = getStartedForm.querySelectorAll('[data-plan-option]');
    const pricingIdInput = getStartedForm.querySelector('[data-pricing-id-input]');
    const countrySelect = getStartedForm.querySelector('[data-country-select]');
    const submitButton = getStartedForm.querySelector('[data-submit-label]');
    const submitText = getStartedForm.querySelector('[data-submit-text]');

    const slugify = (value) => {
        const slug = value
            .normalize('NFKD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '')
            .slice(0, 63);

        return slug || 'acme';
    };

    const syncSlug = () => {
        const slug = slugify(statusPageNameInput.value);

        statusPageSlugInput.value = slug;
        statusPageSlugOutput.textContent = `${slug}.status.notdone.cloud`;
    };

    const syncPlan = () => {
        planOptions.forEach((option) => {
            const optionLabel = option.closest('.plan-option');

            optionLabel?.classList.toggle('is-selected', option.checked);

            if (option.checked) {
                pricingIdInput.value = option.dataset.pricingId;
            }
        });
    };

    const inferCountryCode = () => {
        const locales = navigator.languages?.length ? navigator.languages : [navigator.language];

        for (const locale of locales) {
            try {
                const region = new Intl.Locale(locale).region;

                if (region && countrySelect.querySelector(`option[value="${region}"]`)) {
                    return region;
                }
            } catch {
                const region = locale.split('-').pop()?.toUpperCase();

                if (region && countrySelect.querySelector(`option[value="${region}"]`)) {
                    return region;
                }
            }
        }

        return 'AU';
    };

    statusPageNameInput.addEventListener('input', syncSlug);

    planOptions.forEach((option) => {
        option.addEventListener('change', syncPlan);
    });

    syncSlug();
    syncPlan();

    if (countrySelect && countrySelect.dataset.countryAutodetect === 'true') {
        countrySelect.value = inferCountryCode();
    }

    getStartedForm.addEventListener('submit', () => {
        if (!getStartedForm.checkValidity() || !submitButton || !submitText) {
            return;
        }

        submitText.textContent = submitButton.dataset.submitLabel;
        submitButton.disabled = true;
    });
}
