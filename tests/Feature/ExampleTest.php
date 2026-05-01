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
        ->assertSee('/get-started', false)
        ->assertDontSee('/domains', false)
        ->assertDontSee('/cpanel-web-hosting', false);
});

test('the get started page defaults to the growth trial', function () {
    config(['services.turnstile.site_key' => 'turnstile-site-key']);

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
        ->assertSee('data-submit-label', false)
        ->assertSee('https://challenges.cloudflare.com/turnstile/v0/api.js', false)
        ->assertSee('class="cf-turnstile"', false)
        ->assertSee('data-sitekey="turnstile-site-key"', false)
        ->assertSee('value="growth"', false)
        ->assertSee('name="pricing_id" value="6"', false);
});
