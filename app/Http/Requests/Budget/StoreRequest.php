<?php

namespace App\Http\Requests\Budget;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *  * @method User user
 */
class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => [
                Rule::exists(Category::class, 'id')->where(function (Builder $query) {
                    return $query->where('user_id', $this->user()->id);
                }),
            ],
            'month' => 'required|date_format:m',
            'year' => 'required|date_format:Y',
            'amount' => 'required|numeric|min:1',
        ];
    }
}
