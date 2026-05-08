<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DocsSeeder::class);

        $user = User::query()->firstOrCreate([
            'email' => 'joshua@notdone.cloud',
        ], [
            'name' => 'Joshua Hagan',
            'email_verified_at' => now(),
            'password' => 'changeme123',
        ]);

        $user->forceFill([
            'name' => 'Joshua Hagan',
            'email_verified_at' => $user->email_verified_at ?? now(),
            'password' => 'changeme123',
        ])->save();
    }
}
