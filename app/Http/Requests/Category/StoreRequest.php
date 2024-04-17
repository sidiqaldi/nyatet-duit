<?php

namespace App\Http\Requests\Category;

use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method User user
 */
class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        $user = $this->user();

        return [
            'name' => [
                'required',
                Rule::unique('categories', 'name')->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }),
            ],
            'type' => [
                'required',
                Rule::enum(TransactionType::class),
            ],
        ];
    }
}
