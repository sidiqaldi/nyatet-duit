<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'period' => ['nullable', 'date_format:Y-m'],
        ];
    }
}
