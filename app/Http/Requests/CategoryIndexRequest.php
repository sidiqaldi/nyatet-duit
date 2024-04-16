<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method User user
 */
class CategoryIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
