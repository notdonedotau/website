<?php

namespace App\Http\Requests;

use App\Services\Turnstile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class GetStartedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'password' => ['required', 'string', 'min:10', 'confirmed'],
            'mobile' => ['required', 'string', 'max:40'],
            'country' => ['required', 'string', 'size:2'],
            'postcode' => ['required', 'string', 'max:20'],
            'status_page_name' => ['required', 'string', 'max:120'],
            'status_page_slug' => ['required', 'string', 'max:63', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'plan' => ['required', Rule::in(array_keys($this->planPricingIds()))],
            'pricing_id' => ['required', 'string'],
            'terms_accepted' => ['accepted'],
        ];

        if (app(Turnstile::class)->enabled()) {
            $rules['cf-turnstile-response'] = ['required', 'string', 'max:2048'];
        }

        return $rules;
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $plan = $this->string('plan')->value();

                if (($this->planPricingIds()[$plan] ?? null) !== $this->string('pricing_id')->value()) {
                    $validator->errors()->add('plan', 'Please choose a valid trial plan.');
                }

                if ($validator->errors()->any()) {
                    return;
                }

                $turnstile = app(Turnstile::class);

                if ($turnstile->enabled() && ! $turnstile->verify($this->string('cf-turnstile-response')->value(), $this->ip())) {
                    $validator->errors()->add('cf-turnstile-response', 'Please complete the security check and try again.');
                }
            },
        ];
    }

    public function validated($key = null, $default = null): mixed
    {
        $validated = parent::validated($key, $default);

        if (is_array($validated) && isset($validated['plan'])) {
            $validated['pricing_id'] = $this->planPricingIds()[$validated['plan']];
        }

        return $validated;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status_page_slug' => Str::slug($this->input('status_page_slug') ?: $this->input('status_page_name')),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function planPricingIds(): array
    {
        return [
            'starter' => '4',
            'growth' => '6',
            'business' => '8',
        ];
    }
}
