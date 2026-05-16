<?php

test('the pricing page is disabled', function () {
    $this->get('/pricing')->assertNotFound();
});
