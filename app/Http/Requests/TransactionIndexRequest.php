<?php

namespace App\Http\Requests;

use App\Enums\TransactionType;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Validation\Rule;

/**
 * @property ?string type
 * @property ?int category
 * @property ?int amount
 * @property ?string description
 * @method User user
 */
class TransactionIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'nullable',
                Rule::enum(TransactionType::class),
            ],
            'category' =>  [
                'nullable',
                Rule::exists(Category::class, 'id')->where(function (Builder $query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:10000000000',
            ],
            'description' => [
                'nullable',
                'max:100',
            ],
        ];
    }
}
