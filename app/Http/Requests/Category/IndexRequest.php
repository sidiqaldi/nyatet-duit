<?php

namespace App\Http\Requests\Category;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @method User user
 */
class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
}
