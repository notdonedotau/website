<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertStatus(200)
        ->assertSee('Keep showing up.')
        ->assertSee('Always improving. Never finished.')
        ->assertSee('NOT')
        ->assertSee('DONE')
        ->assertDontSee('images/notdone-logo.svg', false)
        ->assertSee('/about', false)
        ->assertDontSee('/careers', false)
        ->assertDontSee('home-service-card')
        ->assertDontSee('Development')
        ->assertDontSee('Products')
        ->assertSee('https://account.notdone.au', false)
        ->assertDontSee('/domains', false)
        ->assertDontSee('/cpanel-web-hosting', false);
});
