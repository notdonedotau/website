<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Always innovating. Always showing up.')
        ->assertSee('We build practical brands and products')
        ->assertDontSee('images/stackedpay-logo.svg', false)
        ->assertSee('images/logo-dm.svg', false)
        ->assertSee('max-w-6xl', false)
        ->assertSee('px-6 py-6', false)
        ->assertSee('favicon.png', false)
        ->assertSee('#ec2024', false)
        ->assertSee('href="'.route('brands').'"', false)
        ->assertSee('href="'.route('contact').'"', false)
        ->assertSee('View brands')
        ->assertSee('Always innovating. Always showing up.')
        ->assertSee('Terms of Service')
        ->assertSee('Privacy Policy')
        ->assertSee('Website Disclaimer')
        ->assertSee('ABN 43 697 288 583')
        ->assertDontSee('Visit stackedpay.com.au')
        ->assertDontSee('Contact StackedPay')
        ->assertDontSee('name="name"', false)
        ->assertDontSee('name="email"', false)
        ->assertDontSee('name="subject"', false)
        ->assertDontSee('name="message"', false)
        ->assertDontSee('Send enquiry')
        ->assertDontSee('images/notdone-logo.svg', false)
        ->assertDontSee('site-header', false)
        ->assertSee('site-footer', false)
        ->assertDontSee('/about', false)
        ->assertDontSee('/pricing', false)
        ->assertDontSee('/docs', false)
        ->assertDontSee('/careers', false)
        ->assertDontSee('home-service-card')
        ->assertDontSee('Development')
        ->assertDontSee('<a href="'.url('/features').'">Features</a>', false)
        ->assertDontSee('<a href="/blog">Blog</a>', false)
        ->assertDontSee('<a class="site-nav__button" href="https://account.notdone.cloud">Account</a>', false)
        ->assertDontSee('Simple hosted status pages for teams that need clear incident communication.')
        ->assertSee('https://abr.business.gov.au/ABN/View?abn=43697288583', false)
        ->assertDontSee('href="/get-started"', false)
        ->assertDontSee('https://not-done.status.notdone.cloud', false)
        ->assertDontSee('/get-started', false)
        ->assertDontSee('/domains', false)
        ->assertDontSee('/cpanel-web-hosting', false);
});

test('the brands page shows not done brands', function () {
    $this->get('/brands')
        ->assertSuccessful()
        ->assertSee('Brands we are building.')
        ->assertSee('StackedPay')
        ->assertSee('A simpler way for Australians to lay-by gift cards with no hidden fees.')
        ->assertSee('https://stackedpay.com.au', false)
        ->assertSee('aria-label="Not Done home"', false)
        ->assertSeeInOrder(['Brands', 'Contact'])
        ->assertSee('max-w-6xl', false)
        ->assertSee('px-6 py-6', false)
        ->assertSee('px-6 pb-16 pt-10', false)
        ->assertDontSee('Pricing')
        ->assertDontSee('Get Started')
        ->assertDontSee('Docs')
        ->assertDontSee('Blog')
        ->assertSee('Terms of Service')
        ->assertSee('Privacy Policy')
        ->assertSee('Website Disclaimer');
});

test('old public pages are disabled', function (string $path) {
    $this->get($path)->assertNotFound();
})->with([
    'about' => ['/about'],
    'pricing' => ['/pricing'],
    'docs' => ['/docs'],
    'blog' => ['/blog'],
    'get started' => ['/get-started'],
]);
