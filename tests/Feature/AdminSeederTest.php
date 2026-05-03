<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('the database seeder creates the verified notdone administrator', function () {
    User::factory()->unverified()->create([
        'name' => 'Existing User',
        'email' => 'joshua@notdone.cloud',
        'password' => 'old-password',
    ]);

    $this->seed(DatabaseSeeder::class);

    $user = User::query()
        ->where('email', 'joshua@notdone.cloud')
        ->firstOrFail();

    expect($user->name)->toBe('Joshua Hagan')
        ->and($user->hasVerifiedEmail())->toBeTrue()
        ->and(Hash::check('changeme123', $user->password))->toBeTrue();
});
