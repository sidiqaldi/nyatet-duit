<?php

namespace App\Http\Resources;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Transaction */
        $transaction = $this;

        return [
            'id' => $transaction->id,
            'category' => $transaction->category->name ?? 'Others',
            'type_id' => $transaction->type,
            'type' => TransactionType::from($transaction->type)->name,
            'amount' => $transaction->amount,
            'description' => $transaction->description,
            'date' => $transaction->date,
        ];
    }
}
