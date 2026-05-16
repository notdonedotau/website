<?php

test('the get started page is disabled', function () {
    $this->get('/get-started')->assertNotFound();
});

test('the get started form endpoint is disabled', function () {
    $this->post('/get-started', [])->assertNotFound();
});
