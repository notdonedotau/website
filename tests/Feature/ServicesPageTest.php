<?php

test('the domains page is not registered', function () {
    $this->get('/domains')->assertNotFound();
});

test('the cpanel web hosting page is not registered', function () {
    $this->get('/cpanel-web-hosting')->assertNotFound();
});

test('the services endpoint is not registered', function () {
    $this->get('/services')->assertNotFound();
});
