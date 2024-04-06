<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionIndexRequest;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    public function index(TransactionIndexRequest $request): Response
    {
        $transactions = $request->user()->transactions()
            ->when($request->category, function($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->category, function($query, $category) {
                $query->where('category', $category);
            })
            ->when($request->amount, function($query, $amount) {
                $query->where('amount', $amount);
            })
            ->when($request->description, function($query, $description) {
                $query->where('description', 'like', "%$description%");
            })
            ->latest()
            ->paginate(10);

        return Inertia::render('Transaction/Index', [
            'transactions' => TransactionResource::collection($transactions)
        ]);
    }

    public function store(TransactionStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $request->user()->transactions()->create($data);

        return redirect()->back()->with('success', 'New transaction added.');
    }
}
