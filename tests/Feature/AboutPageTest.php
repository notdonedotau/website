<?php

test('the about page is available', function () {
    $response = $this->get('/about');

    $response
        ->assertSuccessful()
        ->assertSee('About Us')
        ->assertSee('Not Done Pty Ltd')
        ->assertSee('nothing worth doing is ever')
        ->assertSee('Not Done is not just a name');
});
