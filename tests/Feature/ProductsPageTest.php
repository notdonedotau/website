<?php

test('the products page is disabled', function () {
    $this->get('/products')->assertNotFound();
});

test('the brands endpoint is registered', function () {
    $this->get('/brands')
        ->assertSuccessful()
        ->assertSee('StackedPay');
});
