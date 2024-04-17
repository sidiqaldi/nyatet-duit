<?php

namespace App\Http\Requests\Transaction;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property ?string type
 * @property ?int category
 * @property ?int amount
 * @property ?string description
 *
 * @method User user
 */
class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
