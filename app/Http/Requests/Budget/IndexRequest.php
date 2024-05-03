<?php

namespace App\Http\Requests\Budget;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ?string period
 *
 * @method User user
 */
class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'period' => 'nullable|date_format:Y-m',
        ];
    }
}
