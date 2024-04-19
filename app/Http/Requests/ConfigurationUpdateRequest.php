<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'locale' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'timezone' => ['required', 'string'],
        ];
    }
}
