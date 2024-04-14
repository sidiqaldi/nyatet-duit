<?php

namespace App\Http\Requests;

use App\Enums\TransactionType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method User user
 */
class TransactionStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'category_id' => [
                'nullable',
                Rule::exists(Category::class, 'id')->where(function (Builder $query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'amount' => ['required', 'min:1', 'max:10000000000'],
            'description' => ['nullable', 'max:500'],
        ];
    }
}
