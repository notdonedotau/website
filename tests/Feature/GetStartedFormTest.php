<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

function validGetStartedPayload(array $overrides = []): array
{
    return array_merge([
        'first_name' => 'Joshua',
        'last_name' => 'Notdone',
        'email' => 'joshua@example.com',
        'password' => 'correct-horse-42',
        'password_confirmation' => 'correct-horse-42',
        'mobile' => '+61400000000',
        'country' => 'AU',
        'postcode' => '6000',
        'status_page_name' => 'Example Status',
        'status_page_slug' => 'example-status',
        'plan' => 'growth',
        'pricing_id' => '6',
        'terms_accepted' => '1',
        'cf-turnstile-response' => 'valid-turnstile-token',
    ], $overrides);
}

function assertRedirectsToBlestaSharedLogin($response, string $username = 'joshua@example.com'): void
{
    $response->assertRedirect();

    $location = $response->headers->get('Location');
    $parts = parse_url($location);
    parse_str($parts['query'] ?? '', $query);

    $redirectUri = 'https://account.notdone.au/client/';

    expect(($parts['scheme'] ?? '').'://'.($parts['host'] ?? '').($parts['path'] ?? ''))->toBe('https://account.notdone.au/plugin/shared_login/')
        ->and($query['u'] ?? null)->toBe($username)
        ->and($query['r'] ?? null)->toBe($redirectUri)
        ->and($query['t'] ?? null)->not->toBeEmpty()
        ->and($query['h'] ?? null)->toBe(hash_hmac('sha256', $query['t'].$username.$redirectUri, 'shared-key'));
}

beforeEach(function () {
    config([
        'app.debug' => false,
        'services.blesta.url' => 'https://account.notdone.au',
        'services.blesta.api_user' => 'api-user',
        'services.blesta.api_key' => 'api-key',
        'services.blesta.client_group_id' => '1',
        'services.blesta.shared_login_key' => 'shared-key',
        'services.notdone_admin.slug_availability_url' => 'https://admin.notdone.cloud/api/admin/workspaces/slug-availability',
        'services.notdone_admin.token' => 'admin-token',
        'services.turnstile.site_key' => 'turnstile-site-key',
        'services.turnstile.secret_key' => 'turnstile-secret-key',
    ]);
});

test('the get started form checks the slug, creates a blesta customer, and creates a service', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['available' => true], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    assertRedirectsToBlestaSharedLogin($response);

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify'
            && $request['secret'] === 'turnstile-secret-key'
            && $request['response'] === 'valid-turnstile-token';
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://admin.notdone.cloud/api/admin/workspaces/slug-availability'
            && $request->hasHeader('Authorization', 'Bearer admin-token')
            && $request['slug'] === 'example-status';
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://account.notdone.au/api/clients/create.json'
            && $request->hasHeader('BLESTA-API-USER', 'api-user')
            && $request->hasHeader('BLESTA-API-KEY', 'api-key')
            && $request['vars']['client_group_id'] === '1'
            && $request['vars']['username'] === 'joshua@example.com'
            && $request['vars']['email'] === 'joshua@example.com'
            && $request['vars']['new_password'] === 'correct-horse-42'
            && $request['vars']['confirm_password'] === 'correct-horse-42'
            && $request['vars']['numbers'][0]['number'] === '+61400000000';
    });

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://account.notdone.au/api/services/add.json'
            && $request->hasHeader('BLESTA-API-USER', 'api-user')
            && $request->hasHeader('BLESTA-API-KEY', 'api-key')
            && $request['vars']['client_id'] === 321
            && $request['vars']['pricing_id'] === '6'
            && $request['vars']['use_module'] === 'true'
            && $request['vars']['workspace_name'] === 'Example Status'
            && $request['vars']['workspace_slug'] === 'example-status'
            && $request['notify'] === 'true'
            && $request['vars']['trial'] === true;
    });
});

test('the get started form shows a clear message when the slug is taken', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['available' => false], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'status_page_name' => 'That status page address is already taken. Please choose another name.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/services/add.json');
});

test('the get started form accepts nested slug availability responses', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['data' => ['available' => true]], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    assertRedirectsToBlestaSharedLogin($response);
});

test('the get started form accepts status based slug availability responses', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['status' => 'available'], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    assertRedirectsToBlestaSharedLogin($response);
});

test('the get started form treats a taken status as unavailable', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['status' => 'taken'], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'status_page_name' => 'That status page address is already taken. Please choose another name.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/services/add.json');
});

test('the get started form does not report a slug as taken when availability is missing', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['success' => true], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'status_page_name' => 'We could not check that status page address. Please try again later.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/services/add.json');
});

test('the get started form shows a clear message when the blesta user already exists', function () {
    config(['app.debug' => false]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['available' => true], 200),
        'account.notdone.au/api/clients/create.json' => Http::response([
            'errors' => [
                'email' => ['The user already exists.'],
            ],
        ], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'email' => 'A user with this email already exists. Please sign in or use another email address.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/services/add.json');
});

test('the get started form shows a clear message when blesta does not provide a useful error', function () {
    config(['app.debug' => false]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['status' => 'available'], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response([
            'success' => false,
        ], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'status_page_name' => 'The account system could not create your trial. Please try again or contact support@notdone.au.',
        ]);
});

test('the get started form shows the raw blesta response when debug is enabled', function () {
    config(['app.debug' => true]);

    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => true], 200),
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['status' => 'available'], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response([
            'success' => false,
            'reason' => 'missing client_id',
        ], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertSessionHasErrors([
            'status_page_name' => 'The account system could not create your trial. Please try again or contact support@notdone.au. Blesta response: {"success":false,"reason":"missing client_id"}',
        ]);
});

test('the get started form validates required fields before calling external services', function () {
    Http::fake();

    $response = $this->from('/get-started')->post('/get-started', []);

    $response
        ->assertRedirect('/get-started')
        ->assertInvalid(['first_name', 'last_name', 'email', 'password', 'mobile', 'status_page_name', 'terms_accepted', 'cf-turnstile-response']);

    Http::assertNothingSent();
});

test('the get started form hides and skips turnstile while debug is enabled', function () {
    config(['app.debug' => true]);

    $this->get('/get-started')
        ->assertSuccessful()
        ->assertDontSee('https://challenges.cloudflare.com/turnstile/v0/api.js', false)
        ->assertDontSee('class="cf-turnstile"', false);

    Http::fake([
        'admin.notdone.cloud/api/admin/workspaces/slug-availability' => Http::response(['available' => true], 200),
        'account.notdone.au/api/clients/create.json' => Http::response(['response' => ['id' => 321]], 200),
        'account.notdone.au/api/services/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload([
        'cf-turnstile-response' => null,
    ]));

    assertRedirectsToBlestaSharedLogin($response);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify');
});

test('the get started form requires password confirmation', function () {
    Http::fake();

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload([
        'password_confirmation' => 'different-password',
    ]));

    $response
        ->assertRedirect('/get-started')
        ->assertInvalid(['password']);

    Http::assertNothingSent();
});

test('the get started form rejects failed turnstile verification before external services', function () {
    Http::fake([
        'challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response(['success' => false], 200),
    ]);

    $response = $this->from('/get-started')->post('/get-started', validGetStartedPayload());

    $response
        ->assertRedirect('/get-started')
        ->assertInvalid([
            'cf-turnstile-response' => 'Please complete the security check and try again.',
        ]);

    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://admin.notdone.cloud/api/admin/workspaces/slug-availability');
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/clients/create.json');
    Http::assertNotSent(fn (Request $request): bool => $request->url() === 'https://account.notdone.au/api/services/add.json');
});
