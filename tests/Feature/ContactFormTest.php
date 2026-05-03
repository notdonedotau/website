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
        'app.debug' => false,
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
        'account.notdone.au/api/support_manager.support_manager_tickets/addReply.json' => Http::response(['response' => 456], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json' => Http::response(['response' => true], 200),
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
            && $request['require_email'] === true;
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/addReply.json'
            && $request->hasHeader('BLESTA-API-USER', 'api-user')
            && $request->hasHeader('BLESTA-API-KEY', 'api-key')
            && $request['ticket_id'] === 123
            && $request['vars']['type'] === 'reply'
            && str_contains($request['vars']['details'], 'Name: Joshua')
            && str_contains($request['vars']['details'], 'Email: joshua@notdone.au')
            && str_contains($request['vars']['details'], 'Can you help with cPanel hosting?')
            && $request['new_ticket'] === true;
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json'
            && $request->hasHeader('BLESTA-API-USER', 'api-user')
            && $request->hasHeader('BLESTA-API-KEY', 'api-key')
            && $request['reply_id'] === 456;
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

test('the contact form hides and skips turnstile while debug is enabled', function () {
    config([
        'app.debug' => true,
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    $this->get('/contact')
        ->assertSuccessful()
        ->assertDontSee('https://challenges.cloudflare.com/turnstile/v0/api.js', false)
        ->assertDontSee('class="cf-turnstile"', false);

    Http::fake([
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => 123], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/addReply.json' => Http::response(['response' => 456], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json' => Http::response(['response' => true], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload([
        'cf-turnstile-response' => null,
    ]));

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_status', 'Thanks, your message has been sent.');

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify');
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
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/addReply.json');
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json');
});

test('the contact form does not show success when blesta returns api errors', function () {
    config([
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response([
            'message' => 'The request cannot be fulfilled due to bad syntax.',
            'errors' => [
                'department_id' => ['exists' => 'The department does not exist.'],
            ],
            'response' => null,
        ], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_error', 'Your message could not be sent. Please try again later.')
        ->assertSessionMissing('contact_status');

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/addReply.json');
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json');
});

test('the contact form does not show success when blesta returns no ticket id', function () {
    config([
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => null], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_error', 'Your message could not be sent. Please try again later.')
        ->assertSessionMissing('contact_status');

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/addReply.json');
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json');
});

test('the contact form does not show success when blesta creates a ticket without a reply', function () {
    config([
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => 123], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/addReply.json' => Http::response([
            'errors' => [
                'details' => ['empty' => 'The details are required.'],
            ],
            'response' => null,
        ], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_error', 'Your message could not be sent. Please try again later.')
        ->assertSessionMissing('contact_status');

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json');
});

test('the contact form does not show success when blesta does not send ticket notifications', function () {
    config([
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.department_id' => '2',
    ]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => 123], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/addReply.json' => Http::response(['response' => 456], 200),
        'account.notdone.au/api/support_manager.support_manager_tickets/sendEmail.json' => Http::response([
            'errors' => [
                'reply_id' => ['exists' => 'The reply does not exist.'],
            ],
            'response' => null,
        ], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', validContactPayload());

    $response
        ->assertRedirect('/contact')
        ->assertSessionHas('contact_error', 'Your message could not be sent. Please try again later.')
        ->assertSessionMissing('contact_status');
});
