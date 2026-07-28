<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:16'],
            'given_name' => ['required', 'string', 'max:64'],
            'family_name' => ['nullable', 'string', 'max:64'],
            'nick_name' => ['nullable', 'string', 'max:32'],
            'email' => ['nullable', 'email', 'max:360'],
        ];
    }
}
