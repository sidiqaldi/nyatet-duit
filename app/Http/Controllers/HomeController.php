<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $totalIncome = Transaction::where('type', TransactionType::Income)->sum('amount');

        $totalExpense = Transaction::where('type', TransactionType::Expense)->sum('amount');

        $totalBalance = $totalIncome - $totalExpense;

        $expense = QueryBuilder::for(Transaction::class)
            ->defaultSort(['-date', '-created_at'])
            ->where('user_id', $request->user()->id)
            ->where('type', TransactionType::Expense)
            ->limit(5)
            ->get();

        $income = QueryBuilder::for(Transaction::class)
            ->defaultSort(['-date', '-created_at'])
            ->where('user_id', $request->user()->id)
            ->where('type', TransactionType::Income)
            ->limit(5)
            ->get();

        $news = Cache::remember('news', now()->addDay(), function() {
            $response = Http::get('https://newsdata.io/api/1/news?apikey=pub_420427c68a089305795a637b3d68095cdaec7&q=uang&country=id&language=id&category=business');
            return $response->json();
        });

        return Inertia::render('Dashboard', [
            'total_balance' => $totalBalance,
            'latest_transactions' => [
                'expense' => $expense,
                'income' => $income,
            ],
            'news' => $news,
        ]);
    }
}
