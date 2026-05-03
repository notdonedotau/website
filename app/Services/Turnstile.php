<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class Turnstile
{
    public function enabled(): bool
    {
        return ! config('app.debug')
            && filled(config('services.turnstile.site_key'))
            && filled(config('services.turnstile.secret_key'));
    }

    /**
     * @param  array{secret_key: string|null, siteverify_url: string|null}  $config
     */
    public function verify(string $token, ?string $remoteIp = null, ?array $config = null): bool
    {
        if (! $this->enabled()) {
            return true;
        }

        $config ??= config('services.turnstile');

        if (blank($token) || ! $this->hasConfig($config)) {
            return false;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post($config['siteverify_url'], array_filter([
                    'secret' => $config['secret_key'],
                    'response' => $token,
                    'remoteip' => $remoteIp,
                ], fn (?string $value): bool => filled($value)));
        } catch (Throwable $exception) {
            Log::warning('Turnstile verification request failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
            ]);

            return false;
        }

        if ($response->failed()) {
            Log::warning('Turnstile verification returned an unsuccessful response.', [
                'status' => $response->status(),
            ]);

            return false;
        }

        return $response->json('success') === true;
    }

    /**
     * @param  array{secret_key: string|null, siteverify_url: string|null}  $config
     */
    private function hasConfig(array $config): bool
    {
        return filled($config['secret_key'])
            && filled($config['siteverify_url']);
    }
}
