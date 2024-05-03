<?php

namespace App\Http\Resources;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Budget */
        $budget = $this;

        return [
            'id' => $budget->id,
            'category_id' => $budget->category_id,
            'category_name' => $budget->category->name ?? '-',
            'period' => $budget->year.'-'.$budget->month,
            'year' => $budget->year,
            'month' => $budget->month,
            'amount' => $budget->amount,
            'transaction' => $budget->transactions[0]->total_amount ?? 0,
        ];
    }
}
