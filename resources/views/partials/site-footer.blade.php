<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__brand">
            <a class="site-footer__mark" href="{{ url('/') }}" aria-label="NOTDONE home">
                <img class="site-logo site-logo--light" src="{{ asset('images/logo-dm.svg') }}" alt="NOTDONE">
                <img class="site-logo site-logo--dark" src="{{ asset('images/logo.svg') }}" alt="NOTDONE">
            </a>
            <p>Always innovating. Always showing up.</p>
        </div>

        <nav class="site-footer__group" aria-label="Company">
            <h2>Company</h2>
            <a href="{{ route('brands') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M3 7h18M6 7v13m12-13v13M8 3h8l2 4H6l2-4Z" />
                </svg>
                <span>Brands</span>
            </a>
        </nav>

        <address class="site-footer__group site-footer__contact">
            <h2>Contact</h2>
            <span>
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" />
                    <path d="M12 10h.01" />
                </svg>
                <span>Perth, Western Australia</span>
            </span>
            <a href="{{ route('contact') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" />
                </svg>
                <span>Contact us</span>
            </a>
            <a href="https://abr.business.gov.au/ABN/View?abn=43697288583" target="_blank" rel="noreferrer">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M14 3h7v7" />
                    <path d="M10 14 21 3" />
                    <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5" />
                </svg>
                <span>ABN 43 697 288 583</span>
            </a>
        </address>
    </div>

    <div class="site-footer__bottom">
        <span>&copy; {{ now()->year }} NOT DONE PTY LTD. All rights reserved.</span>
        <nav class="site-footer__legal" aria-label="Legal">
            <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
            <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
            <a href="{{ url('/website-disclaimer') }}">Website Disclaimer</a>
        </nav>
    </div>
</footer>
