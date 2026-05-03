<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(ContactFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $config = config('services.blesta');

        if (! $this->hasBlestaConfig($config)) {
            return back()
                ->withInput()
                ->with('contact_error', 'The contact form is not available yet. Please try again later.');
        }

        $endpoint = $this->ticketEndpoint($config['url']);
        $ticketPayload = $this->ticketPayload($validated, $config['department_id']);
        $replyEndpoint = $this->ticketReplyEndpoint($config['url']);
        $notificationEndpoint = $this->ticketNotificationEndpoint($config['url']);

        try {
            Log::info('Blesta contact ticket creation started.', $this->logContext(
                $endpoint,
                $validated,
                $ticketPayload
            ));

            $response = Http::asForm()
                ->withHeaders([
                    'BLESTA-API-USER' => $config['api_user'],
                    'BLESTA-API-KEY' => $config['api_key'],
                ])
                ->timeout(10)
                ->post($endpoint, $ticketPayload)
                ->throw();

            $this->throwIfTicketWasNotCreated($response, $endpoint, $validated, $ticketPayload);
            $ticketId = $response->json('response');

            Log::info('Blesta contact ticket creation succeeded.', array_merge(
                $this->logContext($endpoint, $validated, $ticketPayload),
                [
                    'http_status' => $response->status(),
                    'ticket_id' => $ticketId,
                    'blesta_response' => $response->json('response'),
                ],
            ));

            $replyPayload = $this->ticketReplyPayload((int) $ticketId, $validated);

            Log::info('Blesta contact ticket reply creation started.', $this->replyLogContext(
                $replyEndpoint,
                $validated,
                $replyPayload
            ));

            $replyResponse = Http::asForm()
                ->withHeaders([
                    'BLESTA-API-USER' => $config['api_user'],
                    'BLESTA-API-KEY' => $config['api_key'],
                ])
                ->timeout(10)
                ->post($replyEndpoint, $replyPayload)
                ->throw();

            $this->throwIfTicketReplyWasNotCreated($replyResponse, $replyEndpoint, $validated, $replyPayload);

            Log::info('Blesta contact ticket reply creation succeeded.', array_merge(
                $this->replyLogContext($replyEndpoint, $validated, $replyPayload),
                [
                    'http_status' => $replyResponse->status(),
                    'reply_id' => $replyResponse->json('response'),
                    'blesta_response' => $replyResponse->json('response'),
                ],
            ));

            $notificationPayload = $this->ticketNotificationPayload((int) $replyResponse->json('response'));

            Log::info('Blesta contact ticket notification started.', $this->notificationLogContext(
                $notificationEndpoint,
                $validated,
                $notificationPayload
            ));

            $notificationResponse = Http::asForm()
                ->withHeaders([
                    'BLESTA-API-USER' => $config['api_user'],
                    'BLESTA-API-KEY' => $config['api_key'],
                ])
                ->timeout(10)
                ->post($notificationEndpoint, $notificationPayload)
                ->throw();

            $this->throwIfTicketNotificationWasNotSent($notificationResponse, $notificationEndpoint, $validated, $notificationPayload);

            Log::info('Blesta contact ticket notification succeeded.', array_merge(
                $this->notificationLogContext($notificationEndpoint, $validated, $notificationPayload),
                [
                    'http_status' => $notificationResponse->status(),
                    'blesta_response' => $notificationResponse->json('response'),
                ],
            ));
        } catch (Throwable $exception) {
            Log::warning('Blesta contact ticket creation request failed.', array_merge(
                $this->logContext($endpoint, $validated, $ticketPayload),
                [
                    'exception' => $exception::class,
                    'exception_message' => $exception->getMessage(),
                ],
            ));

            return back()
                ->withInput()
                ->with('contact_error', 'Your message could not be sent. Please try again later.');
        }

        return to_route('contact')->with('contact_status', 'Thanks, your message has been sent.');
    }

    /**
     * @param  array{url: string|null, api_user: string|null, api_key: string|null, department_id: string|null}  $config
     */
    private function hasBlestaConfig(array $config): bool
    {
        return filled($config['url'])
            && filled($config['api_user'])
            && filled($config['api_key'])
            && filled($config['department_id']);
    }

    private function ticketEndpoint(string $url): string
    {
        return rtrim($url, '/').'/api/support_manager.support_manager_tickets/add.json';
    }

    private function ticketReplyEndpoint(string $url): string
    {
        return rtrim($url, '/').'/api/support_manager.support_manager_tickets/addReply.json';
    }

    private function ticketNotificationEndpoint(string $url): string
    {
        return rtrim($url, '/').'/api/support_manager.support_manager_tickets/sendEmail.json';
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @return array{vars: array<string, mixed>, require_email: bool}
     */
    private function ticketPayload(array $validated, string $departmentId): array
    {
        return [
            'vars' => [
                'department_id' => $departmentId,
                'email' => $validated['email'],
                'summary' => $validated['subject'],
                'priority' => 'low',
                'status' => 'open',
                'recipients' => [$validated['email']],
            ],
            'require_email' => true,
        ];
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @return array{ticket_id: int, vars: array<string, string>, files: null, new_ticket: bool}
     */
    private function ticketReplyPayload(int $ticketId, array $validated): array
    {
        return [
            'ticket_id' => $ticketId,
            'vars' => [
                'type' => 'reply',
                'details' => $this->ticketDetails($validated),
            ],
            'files' => null,
            'new_ticket' => true,
        ];
    }

    /**
     * @return array{reply_id: int}
     */
    private function ticketNotificationPayload(int $replyId): array
    {
        return [
            'reply_id' => $replyId,
        ];
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{vars: array<string, mixed>, require_email: bool}  $payload
     * @return array<string, mixed>
     */
    private function logContext(string $endpoint, array $validated, array $payload): array
    {
        return [
            'endpoint' => $endpoint,
            'department_id' => data_get($payload, 'vars.department_id'),
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'priority' => data_get($payload, 'vars.priority'),
            'status' => data_get($payload, 'vars.status'),
            'require_email' => $payload['require_email'],
            'recipients' => data_get($payload, 'vars.recipients'),
            'message_length' => mb_strlen($validated['message']),
        ];
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{ticket_id: int, vars: array<string, string>, files: null, new_ticket: bool}  $payload
     * @return array<string, mixed>
     */
    private function replyLogContext(string $endpoint, array $validated, array $payload): array
    {
        return [
            'endpoint' => $endpoint,
            'ticket_id' => $payload['ticket_id'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'reply_type' => data_get($payload, 'vars.type'),
            'new_ticket' => $payload['new_ticket'],
            'message_length' => mb_strlen($validated['message']),
        ];
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{reply_id: int}  $payload
     * @return array<string, mixed>
     */
    private function notificationLogContext(string $endpoint, array $validated, array $payload): array
    {
        return [
            'endpoint' => $endpoint,
            'reply_id' => $payload['reply_id'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
        ];
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{vars: array<string, mixed>, require_email: bool}  $payload
     */
    private function throwIfTicketWasNotCreated(Response $response, string $endpoint, array $validated, array $payload): void
    {
        $json = $response->json();

        if (
            filled(data_get($json, 'errors'))
            || data_get($json, 'success') === false
            || data_get($json, 'status') === 'error'
            || blank(data_get($json, 'response'))
        ) {
            Log::warning('Blesta contact ticket creation returned an invalid response.', array_merge(
                $this->logContext($endpoint, $validated, $payload),
                [
                    'http_status' => $response->status(),
                    'blesta_json' => $json,
                ],
            ));

            throw new RuntimeException('Blesta did not create a support ticket.');
        }
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{ticket_id: int, vars: array<string, string>, files: null, new_ticket: bool}  $payload
     */
    private function throwIfTicketReplyWasNotCreated(Response $response, string $endpoint, array $validated, array $payload): void
    {
        $json = $response->json();

        if (
            filled(data_get($json, 'errors'))
            || data_get($json, 'success') === false
            || data_get($json, 'status') === 'error'
            || blank(data_get($json, 'response'))
        ) {
            Log::warning('Blesta contact ticket reply creation returned an invalid response.', array_merge(
                $this->replyLogContext($endpoint, $validated, $payload),
                [
                    'http_status' => $response->status(),
                    'blesta_json' => $json,
                ],
            ));

            throw new RuntimeException('Blesta did not create the support ticket reply.');
        }
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     * @param  array{reply_id: int}  $payload
     */
    private function throwIfTicketNotificationWasNotSent(Response $response, string $endpoint, array $validated, array $payload): void
    {
        $json = $response->json();

        if (
            filled(data_get($json, 'errors'))
            || data_get($json, 'success') === false
            || data_get($json, 'status') === 'error'
        ) {
            Log::warning('Blesta contact ticket notification returned an invalid response.', array_merge(
                $this->notificationLogContext($endpoint, $validated, $payload),
                [
                    'http_status' => $response->status(),
                    'blesta_json' => $json,
                ],
            ));

            throw new RuntimeException('Blesta did not send the support ticket notification.');
        }
    }

    /**
     * @param  array{name: string, email: string, subject: string, message: string}  $validated
     */
    private function ticketDetails(array $validated): string
    {
        return implode("\n\n", [
            'Name: '.$validated['name'],
            'Email: '.$validated['email'],
            $validated['message'],
        ]);
    }
}
