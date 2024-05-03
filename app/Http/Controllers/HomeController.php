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
        $totalBalance = Transaction::currentUser()->sum('amount');

        $period = Utils::handlePeriod($request->period);

        [$start, $end] = Utils::defaultDate($period);

        $totalExpenseThisMonth = Transaction::where('type', TransactionType::Expense)
            ->dateBetween($start->format('Y-m-d'), $end->format('Y-m-d'))
            ->currentUser()
            ->sum('amount');

        $totalIncomeThisMonth = Transaction::where('type', TransactionType::Income)
            ->dateBetween($start->format('Y-m-d'), $end->format('Y-m-d'))
            ->currentUser()
            ->sum('amount');

        /** @var LengthAwarePaginator|Collection */
        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters(Utils::defaultTransactionFilter())
            ->defaultSort(['-date', '-created_at'])
            ->dateBetween($start->format('Y-m-d'), $end->format('Y-m-d'))
            ->currentUser()
            ->paginate(15);

        $transactions->withQueryString();

        $balancePeriod = Transaction::where('date', '<=', $end)
            ->currentUser()
            ->sum('amount');

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
