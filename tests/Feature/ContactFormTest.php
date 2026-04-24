<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

test('the contact page shows the contact form', function () {
    $response = $this->get('/contact');

    $response
        ->assertSuccessful()
        ->assertSee('Send message')
        ->assertSee('hello@notdone.au')
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
        'account.notdone.au/api/support_manager.support_manager_tickets/add.json' => Http::response(['response' => 123], 200),
    ]);

    $response = $this->from('/contact')->post('/contact', [
        'name' => 'Joshua',
        'email' => 'joshua@notdone.au',
        'subject' => 'Hosting question',
        'message' => 'Can you help with cPanel hosting?',
    ]);

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
});

test('the contact form validates required fields', function () {
    Http::fake();

    $response = $this->from('/contact')->post('/contact', []);

    $response
        ->assertRedirect('/contact')
        ->assertInvalid(['name', 'email', 'subject', 'message']);

    Http::assertNothingSent();
});
