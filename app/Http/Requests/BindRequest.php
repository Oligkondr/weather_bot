<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class BindRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $client = $this->route('client');

        return [
            'login' => 'required|string',
            'code' => [
                'required',
                'string',
                'regex:/^\d{4}$/',
                function (string $attribute, mixed $value, Closure $fail) use ($client) {
                    if ($value != $client->code) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ],
        ];
    }
}
