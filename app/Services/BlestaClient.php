<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class BlestaClient
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function createTrialService(array $data): void
    {
        $config = config('services.blesta');

        if (! $this->hasConfig($config)) {
            throw new RuntimeException('The trial signup service is not available yet. Please try again later.');
        }

        $clientId = $this->createClient($config, $data);
        $this->createService($config, $data, $clientId);
    }

    public function sharedLoginUrl(string $username): string
    {
        $config = config('services.blesta');

        if (! $this->hasSharedLoginConfig($config)) {
            throw new RuntimeException('Your trial was created, but we could not log you in automatically. Please log in at account.notdone.cloud.');
        }

        $timestamp = (string) now()->timestamp;
        $redirectUri = rtrim($config['url'], '/').'/client/';
        $hash = hash_hmac('sha256', $timestamp.$username.$redirectUri, $config['shared_login_key']);

        return rtrim($config['url'], '/').'/plugin/shared_login/?'.http_build_query([
            'u' => $username,
            't' => $timestamp,
            'r' => $redirectUri,
            'h' => $hash,
        ], '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * @param  array{url: string, api_user: string, api_key: string, client_group_id: string}  $config
     * @param  array<string, mixed>  $data
     */
    private function createClient(array $config, array $data): int
    {
        $response = $this->post(
            $config,
            'clients/create.json',
            [
                'vars' => $this->clientPayload($config, $data),
            ],
            $data,
            'Blesta client creation failed.'
        );

        $clientId = $this->clientIdFromResponse($response);

        if (! $clientId) {
            $this->logFailedResponse(null, $data, $response, 'Blesta client creation did not return a client ID.');

            throw new RuntimeException($this->debugMessage(
                'The account system created a customer but did not return a client ID. Please contact support@notdone.au.',
                $response
            ));
        }

        return $clientId;
    }

    /**
     * @param  array{url: string, api_user: string, api_key: string}  $config
     * @param  array<string, mixed>  $data
     */
    private function createService(array $config, array $data, int $clientId): void
    {
        $this->post(
            $config,
            'services/add.json',
            [
                'vars' => $this->servicePayload($data, $clientId),
                'notify' => 'true',
            ],
            $data,
            'Blesta trial service creation failed.'
        );
    }

    /**
     * @param  array{url: string, api_user: string, api_key: string}  $config
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $formData
     * @return array<string, mixed>|null
     */
    private function post(array $config, string $endpoint, array $payload, array $formData, string $logMessage): ?array
    {
        try {
            $response = Http::asForm()
                ->withHeaders([
                    'BLESTA-API-USER' => $config['api_user'],
                    'BLESTA-API-KEY' => $config['api_key'],
                ])
                ->timeout(10)
                ->post($this->endpoint($config, $endpoint), $payload)
                ->throw()
                ->json();
        } catch (RequestException $exception) {
            $this->logFailedResponse($exception->response, $formData, null, $logMessage);

            throw new RuntimeException(
                $this->debugMessage(
                    $this->errorMessage($exception->response->json()) ?? 'The account system could not create your trial. Please try again or contact support@notdone.au.',
                    $exception->response->json()
                ),
                previous: $exception
            );
        }

        if ($this->hasError($response)) {
            $this->logFailedResponse(null, $formData, $response, $logMessage);

            throw new RuntimeException($this->debugMessage(
                $this->errorMessage($response) ?? 'The account system could not create your trial. Please try again or contact support@notdone.au.',
                $response
            ));
        }

        return $response;
    }

    /**
     * @param  array{url: string|null, api_user: string|null, api_key: string|null, client_group_id: string|null}  $config
     */
    private function hasConfig(array $config): bool
    {
        return filled($config['url'])
            && filled($config['api_user'])
            && filled($config['api_key'])
            && filled($config['client_group_id']);
    }

    /**
     * @param  array{url: string|null, shared_login_key: string|null}  $config
     */
    private function hasSharedLoginConfig(array $config): bool
    {
        return filled($config['url'])
            && filled($config['shared_login_key']);
    }

    /**
     * @param  array{url: string}  $config
     */
    private function endpoint(array $config, string $endpoint): string
    {
        return rtrim($config['url'], '/').'/api/'.ltrim($endpoint, '/');
    }

    /**
     * @param  array{client_group_id: string}  $config
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function clientPayload(array $config, array $data): array
    {
        return [
            'username' => $data['email'],
            'new_password' => $data['password'],
            'confirm_password' => $data['password'],
            'client_group_id' => $config['client_group_id'],
            'status' => 'active',
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'country' => $data['country'],
            'zip' => $data['postcode'],
            'numbers' => [
                [
                    'number' => $data['mobile'],
                    'type' => 'phone',
                    'location' => 'mobile',
                ],
            ],
            'settings' => [
                'username_type' => 'email',
            ],
            'send_registration_email' => 'true',
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function servicePayload(array $data, int $clientId): array
    {
        return [
            'client_id' => $clientId,
            'pricing_id' => $data['pricing_id'],
            'qty' => 1,
            'status' => 'active',
            'use_module' => 'true',
            'workspace_name' => $data['status_page_name'],
            'workspace_slug' => $data['status_page_slug'],
            'trial' => true,
        ];
    }

    /**
     * @param  array<string, mixed>|null  $response
     */
    private function clientIdFromResponse(?array $response): ?int
    {
        $clientId = Arr::first([
            data_get($response, 'response.id'),
            data_get($response, 'response.client_id'),
            data_get($response, 'response.client.id'),
            data_get($response, 'id'),
            data_get($response, 'client_id'),
        ], fn (mixed $value): bool => filled($value));

        return $clientId ? (int) $clientId : null;
    }

    /**
     * @param  array<string, mixed>|null  $response
     */
    private function errorMessage(?array $response): ?string
    {
        $message = Arr::first([
            data_get($response, 'errors.email.0'),
            data_get($response, 'errors.email.exists'),
            data_get($response, 'errors.username.0'),
            data_get($response, 'errors.username.exists'),
            data_get($response, 'errors.0'),
            data_get($response, 'error'),
            data_get($response, 'message'),
        ]);

        if (! is_string($message) || blank($message)) {
            return null;
        }

        if (str_contains(strtolower($message), 'exist')) {
            return 'A user with this email already exists. Please sign in or use another email address.';
        }

        return $message;
    }

    /**
     * @param  array<string, mixed>|null  $response
     */
    private function hasError(?array $response): bool
    {
        return filled(data_get($response, 'errors'))
            || data_get($response, 'success') === false
            || data_get($response, 'status') === 'error';
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>|null  $json
     */
    private function logFailedResponse(?Response $response, array $data, ?array $json = null, string $message = 'Blesta request failed.'): void
    {
        Log::warning($message, [
            'status' => $response?->status(),
            'body' => $response?->body(),
            'json' => $json ?? $response?->json(),
            'email' => $data['email'] ?? null,
            'pricing_id' => $data['pricing_id'] ?? null,
            'status_page_slug' => $data['status_page_slug'] ?? null,
        ]);
    }

    /**
     * @param  array<string, mixed>|null  $response
     */
    private function debugMessage(string $message, ?array $response): string
    {
        if (! config('app.debug')) {
            return $message;
        }

        return $message.' Blesta response: '.json_encode($response, JSON_UNESCAPED_SLASHES);
    }
}
