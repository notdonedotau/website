<?php

test('the careers page is disabled', function () {
    $this->get('/careers')->assertNotFound();
});
