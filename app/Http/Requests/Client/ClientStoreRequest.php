<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:clients,username', 'regex:/^[a-zA-Z0-9-]+$/'],
            'expire_at' => ['nullable', Rule::date()->afterToday()],
        ];
    }
}
