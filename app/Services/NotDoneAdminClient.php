<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class NotDoneAdminClient
{
    public function isSlugAvailable(string $slug): bool
    {
        $config = config('services.notdone_admin');

        if (! $this->hasConfig($config)) {
            throw new RuntimeException('We could not check that status page address. Please try again later.');
        }

        $response = Http::withToken($config['token'])
            ->acceptJson()
            ->timeout(10)
            ->post($config['slug_availability_url'], [
                'slug' => $slug,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('We could not check that status page address. Please try again later.');
        }

        $availability = $this->availabilityFromResponse($response->json());

        if ($availability === null) {
            throw new RuntimeException('We could not check that status page address. Please try again later.');
        }

        return $availability;
    }

    /**
     * @param  array{slug_availability_url: string|null, token: string|null}  $config
     */
    private function hasConfig(array $config): bool
    {
        return filled($config['slug_availability_url'])
            && filled($config['token']);
    }

    /**
     * @param  array<string, mixed>|null  $response
     */
    private function availabilityFromResponse(?array $response): ?bool
    {
        foreach (['available', 'data.available', 'is_available', 'data.is_available'] as $key) {
            if (data_get($response, $key) !== null) {
                return filter_var(data_get($response, $key), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
            }
        }

        foreach (['taken', 'data.taken', 'exists', 'data.exists', 'unavailable', 'data.unavailable'] as $key) {
            if (data_get($response, $key) !== null) {
                $value = filter_var(data_get($response, $key), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

                return $value === null ? null : ! $value;
            }
        }

        foreach (['status', 'data.status'] as $key) {
            $status = data_get($response, $key);

            if (! is_string($status)) {
                continue;
            }

            return match (strtolower($status)) {
                'available' => true,
                'taken' => false,
                default => null,
            };
        }

        return null;
    }
}
