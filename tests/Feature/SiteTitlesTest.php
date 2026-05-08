<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('page titles use the configured app name', function (string $path, string $titlePrefix) {
    config(['app.name' => 'Example Status']);

    $this->get($path)
        ->assertSuccessful()
        ->assertSee("<title>{$titlePrefix}Example Status</title>", false);
})->with([
    'home' => ['/', ''],
    'about' => ['/about', 'About Us | '],
    'pricing' => ['/pricing', 'Pricing | '],
    'docs' => ['/docs', 'Docs | '],
    'blog' => ['/blog', 'Blog | '],
    'get started' => ['/get-started', 'Get Started | '],
    'contact' => ['/contact', 'Contact | '],
    'privacy policy' => ['/privacy-policy', 'Privacy Policy | '],
    'terms of service' => ['/terms-of-service', 'Terms of Service | '],
    'website disclaimer' => ['/website-disclaimer', 'Website Disclaimer | '],
]);

test('the features route is disabled', function () {
    $this->get('/features')
        ->assertNotFound();
});
