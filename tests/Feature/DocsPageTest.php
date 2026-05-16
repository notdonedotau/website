<?php

test('public docs pages are disabled', function (string $path) {
    $this->get($path)->assertNotFound();
})->with([
    'docs index' => ['/docs'],
    'docs article' => ['/docs/example-doc'],
]);
