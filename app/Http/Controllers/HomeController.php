<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\HomeRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Utils;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class HomeController extends Controller
{
    public function index(HomeRequest $request): Response
    {
        $totalBalance = Transaction::sum('amount');

        $period = Utils::handlePeriod($request->period);

        [$start, $end] = Utils::defaultDate($period);

        $totalExpenseThisMonth = Transaction::where('type', TransactionType::Expense)
            ->dateBetween($start, $end)
            ->sum('amount');

        $totalIncomeThisMonth = Transaction::where('type', TransactionType::Income)
            ->dateBetween($start, $end)
            ->sum('amount');

        /** @var LengthAwarePaginator|Collection */
        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters(Utils::defaultTransactionFilter())
            ->defaultSort(['-date', '-created_at'])
            ->dateBetween($start, $end)
            ->paginate(15);

        $transactions->withQueryString();

        $balancePeriod = Transaction::where('date', '<=', $end)->sum('amount');

        return Inertia::render('Dashboard/Index', [
            'totalBalance' => $totalBalance,
            'totalExpense' => $totalExpenseThisMonth,
            'totalIncome' => $totalIncomeThisMonth,
            'transactions' => TransactionResource::collection($transactions),
            'balancePeriod' => $balancePeriod,
            'period' => [
                'year' => $period->year,
                'month' => $period->month,
            ],
        ]);
    }
}
