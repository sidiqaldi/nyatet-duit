<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Http\Requests\Budget\IndexRequest;
use App\Http\Requests\Budget\StoreRequest;
use App\Http\Resources\BudgetResource;
use App\Http\Resources\CategoryResource;
use App\Models\Budget;
use App\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class BudgetController extends Controller
{
    public function index(IndexRequest $request): Response|JsonResponse
    {
        $period = Utils::handlePeriod($request->period);

        $budgetData = $request->user()->budgets()
            ->with(['category', 'transactions' => function ($query) use ($period) {
                $query->selectRaw('category_id, SUM(amount) * -1 as total_amount, date')
                    ->whereBetween('date', [
                        $period->startOfMonth()->format('Y-m-d'),
                        $period->endOfMonth()->format('Y-m-d')
                    ])
                    ->groupBy('category_id');
            }])
            ->where('year', $period->year)
            ->where('month', $period->month)
            ->get();

        $exceptCategory = $budgetData->pluck('category_id');

        $budgets = BudgetResource::collection($budgetData);

        $categories = CategoryResource::collection($request->user()->categories()
            ->whereNotIn('id', $exceptCategory)
            ->where('type', TransactionType::Expense)
            ->get()
        );

        if ($request->requestNonInertia) {
            return response()->json(['data' => $budgets]);
        }

        $date = [
            'year' => $period->year,
            'month' => $period->month,
        ];

        $canCreate = $period->startOfMonth()->gte(now()->startOfMonth());

        return Inertia::render('Budget/Index', compact('budgets', 'categories', 'date', 'canCreate'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $request->user()->budgets()->updateOrCreate([
            'category_id' => $data['category_id'],
            'year' => $data['year'],
            'month' => $data['month'],
        ], [
            'amount' => $data['amount'],
        ]);

        if ($request->requestNonInertia) {
            return response()->json(['data' => 'OK']);
        }

        return redirect()->back()->with('success', 'Budget record updated!');
    }

    public function destroy(Budget $budget)
    {
        Gate::authorize('delete', $budget);

        $budget->delete();

        return redirect()->back()->with('success', 'Budget record deleted!');
    }
}
