<?php

$noticeText = 'A quick note: Not Done is actively being developed, and some features shown on this page may still be in progress, limited, or rolling out over time.';

test('product pages show the development notice with a contact link', function (string $path) use ($noticeText) {
    $this->get($path)
        ->assertSuccessful()
        ->assertSee($noticeText)
        ->assertSee('href="'.route('contact').'"', false)
        ->assertSee('>contact us</a>', false)
        ->assertDontSee('early access notice');
})->with([
    'pricing' => ['/pricing'],
    'get started' => ['/get-started'],
]);
