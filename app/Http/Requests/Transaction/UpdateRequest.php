<?php

namespace App\Http\Requests\Transaction;

use App\Enums\TransactionType;
use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'category_id' => [
                Rule::exists(Category::class, 'id')->where(function (Builder $query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'amount' => ['required', 'min:1', 'max:10000000000'],
            'description' => ['nullable', 'max:500'],
        ];
    }
}
