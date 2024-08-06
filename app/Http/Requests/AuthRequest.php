<?php

namespace App\Http\Requests;

use App\Models\Client;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Client $client
 */
class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $client = Client::query()
            ->where('login', $this->route('login'))
            ->first();

        $this->merge([
            'client' => $client,
        ]);

        return [
            'code' => [
                'required',
                'string',
                'regex:/^\d{4}$/',
                function (string $attribute, mixed $value, Closure $fail) use ($client) {
                    if (!$client) {
                        $fail('Login not found.');
                    } elseif ($value != $client->code) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];
    }
}
