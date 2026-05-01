<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStartedRequest;
use App\Services\BlestaClient;
use App\Services\NotDoneAdminClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RuntimeException;

class GetStartedController extends Controller
{
    public function create(): View
    {
        return view('get-started');
    }

    public function store(
        GetStartedRequest $request,
        NotDoneAdminClient $notDoneAdmin,
        BlestaClient $blesta,
    ): RedirectResponse {
        $validated = $request->validated();

        try {
            if (! $notDoneAdmin->isSlugAvailable($validated['status_page_slug'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'status_page_name' => 'That status page address is already taken. Please choose another name.',
                    ]);
            }

            $blesta->createTrialService($validated);

            return redirect()->away($blesta->sharedLoginUrl($validated['email']));
        } catch (RuntimeException $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    $this->errorField($exception->getMessage()) => $exception->getMessage(),
                ]);
        }
    }

    private function errorField(string $message): string
    {
        return str_contains(strtolower($message), 'user with this email')
            ? 'email'
            : 'status_page_name';
    }
}
