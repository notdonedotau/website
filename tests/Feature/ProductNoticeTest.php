<?php

test('legacy product pages are disabled', function (string $path) {
    $this->get($path)->assertNotFound();
})->with([
    'pricing' => ['/pricing'],
    'get started' => ['/get-started'],
]);
