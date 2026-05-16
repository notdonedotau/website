<?php

test('public blog pages are disabled', function (string $path) {
    $this->get($path)->assertNotFound();
})->with([
    'blog index' => ['/blog'],
    'blog article' => ['/blog/example-article'],
    'blog og image' => ['/blog/example-article/og-image'],
]);
