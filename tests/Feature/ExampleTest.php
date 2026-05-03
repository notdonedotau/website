<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Keep showing up.')
        ->assertSee('Even when things don’t.')
        ->assertSee('NOT')
        ->assertSee('DONE')
        ->assertDontSee('images/notdone-logo.svg', false)
        ->assertSee('/about', false)
        ->assertDontSee('/careers', false)
        ->assertDontSee('home-service-card')
        ->assertDontSee('Development')
        ->assertDontSee('Products')
        ->assertSeeInOrder(['Pricing', 'Contact', 'Get Started'])
        ->assertDontSee('<a href="'.route('blog.index').'">Blog</a>', false)
        ->assertDontSee('<a class="site-nav__button" href="https://account.notdone.cloud">Account</a>', false)
        ->assertSeeInOrder(['Product', 'Features', 'Pricing', 'Get Started', 'Status'])
        ->assertSeeInOrder(['Company', 'About', 'Blog', 'Account Login'])
        ->assertSeeInOrder(['Contact', 'Perth, Western Australia', 'Contact us', 'ABN 43 697 288 583'])
        ->assertSee('Simple hosted status pages for teams that need clear incident communication.')
        ->assertSee('https://abr.business.gov.au/ABN/View?abn=43697288583', false)
        ->assertSee('href="'.route('get-started').'"', false)
        ->assertSee('https://not-done.status.notdone.cloud', false)
        ->assertSee('/get-started', false)
        ->assertDontSee('/domains', false)
        ->assertDontSee('/cpanel-web-hosting', false);
});

test('the get started page defaults to the growth trial', function () {
    config(['services.turnstile.site_key' => 'turnstile-site-key']);
    config(['services.turnstile.secret_key' => 'turnstile-secret-key']);
    config(['app.debug' => false]);

    $response = $this->get('/get-started');

    $response
        ->assertSuccessful()
        ->assertSee('No credit card required')
        ->assertSee('name="first_name"', false)
        ->assertSee('name="last_name"', false)
        ->assertSee('name="mobile"', false)
        ->assertSee('name="password"', false)
        ->assertSee('name="password_confirmation"', false)
        ->assertSee('name="country"', false)
        ->assertSee('name="postcode"', false)
        ->assertSee('name="terms_accepted"', false)
        ->assertSee('Privacy Policy')
        ->assertSee('Terms of Service')
        ->assertSee('value="AU" selected', false)
        ->assertSee('United States')
        ->assertSee('South Africa')
        ->assertSee('Japan')
        ->assertSee('Status Page Name')
        ->assertSee('Your generated page')
        ->assertSee('acme.status.notdone.cloud')
        ->assertSee('data-submit-label', false)
        ->assertSee('https://challenges.cloudflare.com/turnstile/v0/api.js', false)
        ->assertSee('class="cf-turnstile"', false)
        ->assertSee('data-sitekey="turnstile-site-key"', false)
        ->assertSee('value="growth"', false)
        ->assertSee('name="pricing_id" value="6"', false);
});
