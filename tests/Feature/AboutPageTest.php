<?php

test('the about page is disabled', function () {
    $this->get('/about')->assertNotFound();
});
