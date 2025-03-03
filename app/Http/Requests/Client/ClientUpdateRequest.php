<?php

namespace App\Http\Requests\Client;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class ClientUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z0-9-]+$/',
                (new Unique(Client::class))->ignore($this->route()->parameter('client')->id),
            ],
            'expire_at' => ['nullable', Rule::date()->afterToday()],
        ];
    }
}
