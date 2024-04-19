<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\ReportIndexRequest;
use App\Models\Transaction;
use App\Utils;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{
    public function index(ReportIndexRequest $request): Response
    {
        $period = Utils::handlePeriod($request->period);

        [$start, $end] = Utils::defaultDate($period);

        $expensePieData = $this->expensePieData($start, $end);

        $incomePieData = $this->incomePieData($start, $end);

        $expenseLineData = $this->expenseLineData($start, $end);

        $data = compact('expensePieData', 'incomePieData', 'expenseLineData');

        $data['period'] = [
            'year' => $period->year,
            'month' => $period->month,
        ];

        return Inertia::render('Report/Index', $data);
    }

    protected function expensePieData($start, $end)
    {
        /** @var LengthAwarePaginator|Collection * */
        $expenses = QueryBuilder::for(Transaction::class)
            ->with('category')
            ->where('type', TransactionType::Expense)
            ->dateBetween($start, $end)
            ->where('user_id', request()->user()->id)
            ->get();

        $data = [];

        /** @var Transaction */
        foreach($expenses as $transaction) {
            $data[$transaction->category->name] = isset($data[$transaction->category->name])
                ? $data[$transaction->category->name] + $transaction->amount
                : $transaction->amount;
        }

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Total expense',
                    'data' => array_values($data),
                    'hoverOffset' => 4,
                ]
            ]
        ];
    }

    protected function incomePieData($start, $end)
    {
        /** @var LengthAwarePaginator|Collection * */
        $incomes = QueryBuilder::for(Transaction::class)
            ->with('category')
            ->where('type', TransactionType::Income)
            ->dateBetween($start, $end)
            ->get();

        $data = [];

        /** @var Transaction */
        foreach($incomes as $transaction) {
            $data[$transaction->category->name] = isset($data[$transaction->category->name])
                ? $data[$transaction->category->name] + $transaction->amount
                : $transaction->amount;
        }

        return [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'Total expense',
                    'data' => array_values($data),
                    'hoverOffset' => 4,
                ]
            ]
        ];
    }

    protected function expenseLineData($startDate, $endDate)
    {
        $allDates = collect(range(0, $startDate->diffInDays($endDate)))
            ->map(function ($day) use ($startDate) {
                return $startDate->copy()->addDays($day)->toDateString();
            });

        $expense = DB::table('transactions')
            ->select(
                DB::raw('DATE(date) as transaction_date'),
                DB::raw('COALESCE(SUM(amount), 0) * -1 as total_amount')
            )
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->where('Type', TransactionType::Expense)
            ->where('user_id', request()->user()->id)
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->pluck('total_amount', 'transaction_date');

        $expenseResult = $allDates->map(function ($date) use ($expense) {
            return [
                'transaction_date' => $date,
                'total_amount' => $expense->has($date) ? $expense[$date] : 0,
            ];
        });

        $income = DB::table('transactions')
            ->select(
                DB::raw('DATE(date) as transaction_date'),
                DB::raw('COALESCE(SUM(amount), 0) as total_amount')
            )
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->where('Type', TransactionType::Income)
            ->where('user_id', request()->user()->id)
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->pluck('total_amount', 'transaction_date');

        $incomeResult = $allDates->map(function ($date) use ($income) {
            return [
                'transaction_date' => $date,
                'total_amount' => $income->has($date) ? $income[$date] : 0,
            ];
        });

        $labels = $expenseResult->pluck('transaction_date')
            ->transform(fn ($val) => Carbon::parse($val)->format('m-d'))
            ->toArray();

        $expenseDataset = $expenseResult->pluck('total_amount')->toArray();

        $incomeDataset = $incomeResult->pluck('total_amount')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Expense flow',
                    'data' => $expenseDataset,
                    'fill' => false,
                    'borderColor' => 'rgb(240, 128, 128)',
                    'tension' => 0.1,
                ],
                [
                    'label' => 'Income flow',
                    'data' => $incomeDataset,
                    'fill' => false,
                    'borderColor' => 'rgb(176, 224, 230)',
                    'tension' => 0.1,
                ],
            ]
        ];
    }
}
