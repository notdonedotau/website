<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
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

        try {
            Http::asForm()
                ->withHeaders([
                    'BLESTA-API-USER' => $config['api_user'],
                    'BLESTA-API-KEY' => $config['api_key'],
                ])
                ->timeout(10)
                ->post($this->ticketEndpoint($config['url']), [
                    'vars' => [
                        'department_id' => $config['department_id'],
                        'email' => $validated['email'],
                        'summary' => $validated['subject'],
                        'priority' => 'low',
                        'status' => 'open',
                        'details' => $this->ticketDetails($validated),
                        'recipients' => [$validated['email']],
                    ],
                    'require_email' => true,
                ])
                ->throw();
        } catch (Throwable) {
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
