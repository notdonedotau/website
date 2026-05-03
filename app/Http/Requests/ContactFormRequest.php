<?php

namespace App\Http\Requests;

use App\Services\Turnstile;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
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
}
