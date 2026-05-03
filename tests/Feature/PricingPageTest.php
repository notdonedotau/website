<?php

test('business plan includes audit logs', function () {
    $response = $this->get('/pricing');

    $response
        ->assertSuccessful()
        ->assertSeeTextInOrder([
            'Business',
            'Custom roles',
            'Audit logs',
            'Get Started',
        ])
        ->assertSeeTextInOrder([
            'Features by plan.',
            'Security & Administration',
            'Custom roles',
            'Audit logs',
        ]);
});
