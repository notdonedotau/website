<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

function validContactPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Joshua',
        'email' => 'joshua@notdone.au',
        'subject' => 'Hosting question',
        'message' => 'Can you help with cPanel hosting?',
        'cf-turnstile-response' => 'valid-turnstile-token',
    ], $overrides);
}

beforeEach(function () {
    config([
        'services.turnstile.site_key' => 'turnstile-site-key',
        'services.turnstile.secret_key' => 'turnstile-secret-key',
    ]);
});

test('the contact page shows the contact form', function () {
    $response = $this->get('/contact');

    $response
        ->assertSuccessful()
        ->assertSee('Send message')
        ->assertSee('support@notdone.au')
        ->assertSee('https://challenges.cloudflare.com/turnstile/v0/api.js', false)
        ->assertSee('class="cf-turnstile"', false)
        ->assertSee('data-sitekey="turnstile-site-key"', false)
        ->assertSee('name="email"', false);
});

test('the contact form opens a blesta ticket', function () {
    config([
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_status', 'Thanks, your message has been sent.');

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/add.json'
            && $request->hasHeader('BLESTA-API-USER', 'api-user')
            && $request->hasHeader('BLESTA-API-KEY', 'api-key')
            && $request['vars']['department_id'] === '2'
            && $request['vars']['email'] === 'joshua@notdone.au'
            && $request['vars']['summary'] === 'Hosting question'
            && $request['vars']['priority'] === 'low'
            && $request['vars']['status'] === 'open'
            && str_contains($request['vars']['details'], 'Can you help with cPanel hosting?')
            && $request['require_email'] === true;
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify'
            && $request['secret'] === 'turnstile-secret-key'
            && $request['response'] === 'valid-turnstile-token';
    });
});

test('the contact form validates required fields', function () {
    Http::fake();

    $response = $this->from('/contact')->post('/contact', []);

    $response
        ->assertRedirect('/contact')
        ->assertInvalid(['name', 'email', 'subject', 'message', 'cf-turnstile-response']);

    Http::assertNothingSent();
});

test('the contact form rejects failed turnstile verification', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => false], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertInvalid([
            'cf-turnstile-response' => 'Please complete the security check and try again.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/add.json');
});
