<?php

test('the products page is available', function () {
    $response = $this->get('/products');

    $response
        ->assertSuccessful()
        ->assertSee('JMCO.cx')
        ->assertSee('View JMCO.cx')
        ->assertSee('https://jmco.cx', false);
});

test('the brands endpoint is not registered', function () {
    $this->get('/brands')->assertNotFound();
});
