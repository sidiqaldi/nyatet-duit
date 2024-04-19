<?php

namespace App\Imports;

use App\Enums\TransactionType;
use App\Models\Category;
use App\Models\Transaction;
use App\Utils;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionImport implements ToCollection, WithHeadingRow
{
    public function __construct(public string $period, public int $userId)
    {

    }

    public function collection(Collection $collection)
    {
        $query = Transaction::currentUser();

        if ($this->period != 'all') {
            $carbonPeriod = Utils::handlePeriod($this->period);

            [$start, $end] = Utils::defaultDateByPeriod($this->period);

            $query->dateBetween($start, $end);
        }

        $query->delete();

        foreach ($collection as $row)
        {
            if ($this->period != 'all') {
                $rowDate = Carbon::parse($row['date']);

                if ($carbonPeriod->year == $rowDate->year && $carbonPeriod->month == $rowDate->month) {
                    $this->handleCreate($row);

                } else {

                    continue;
                }

            } else {
                $this->handleCreate($row);
            }

        }
    }

    protected function handleCreate($row)
    {
        $category = $row['category']
            ? Category::firstOrCreate([
                'user_id' => $this->userId,
                'name' => $row['category'],
            ])->id
            : null;

        Transaction::create([
            'user_id' => $this->userId,
            'date'=>  $row['date'],
            'type' =>  TransactionType::fromName($row['type']),
            'category_id' => $category,
            'amount' =>  $row['amount'],
            'description' =>  $row['description'],
        ]);
    }
}
