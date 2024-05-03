<?php

namespace App\Exports;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Utils;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    public function __construct(public string $period)
    {
    }

    public function headings(): array
    {
        return [
            'date',
            'type',
            'category',
            'amount',
            'description',
        ];
    }

    public function collection()
    {
        $query = Transaction::with('category')->currentUser();

        if ($this->period != 'all') {
            [$start, $end] = Utils::defaultDateByPeriod($this->period);

            $query->dateBetween($start, $end);
        }

        return $query->get()->transform(function ($transaction) {
            return [
                'date' => $transaction->date,
                'type' => TransactionType::from($transaction->type)->name,
                'category' => $transaction->category->name ?? '',
                'amount' => $transaction->amount,
                'description' => $transaction->description,
            ];
        });
    }
}
