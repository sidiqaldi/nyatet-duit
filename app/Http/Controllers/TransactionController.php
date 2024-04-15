<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Http\Requests\TransactionIndexRequest;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Utils;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

class TransactionController extends Controller
{
    public function index(TransactionIndexRequest $request): Response
    {
        /** @var LengthAwarePaginator|Collection * */
        $transactions = QueryBuilder::for(Transaction::class)
            ->allowedFilters(Utils::defaultTransactionFilter())
            ->allowedSorts(['date', 'amount'])
            ->defaultSort(['-date', '-created_at'])
            ->where('user_id', $request->user()->id)
            ->paginate(10);

        $transactions->withQueryString();

        return Inertia::render('Transaction/Index', [
            'transactions' => TransactionResource::collection($transactions),
            'date_between' => $request->has('filter.date_between') ? explode(',', $request->filter['date_between']) : Utils::defaultDate(),
        ]);
    }

    public function store(TransactionStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $transaction = $request->user()->transactions()->create($data);

        TransactionCreated::dispatch($transaction);

        return redirect()->back()->with('success', 'New transaction added.');
    }

    public function update(TransactionUpdateRequest $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $data = $request->validated();

        $transaction->fill($data);

        if ($transaction->isDirty()) {
            $transaction->save();

            TransactionUpdated::dispatch($transaction);
        }

        return redirect()->back()->with('success', 'Transaction edited.');
    }

    public function destroy(Transaction $transaction)
    {
        Gate::authorize('delete', $transaction);

        $date = $transaction->date;

        $transaction->delete();

        TransactionDeleted::dispatch($date);

        return redirect()->back()->with('success', 'Transaction deleted.');
    }
}
