<?php

namespace App\Http\Controllers;

use App\Enums\TransactionType;
use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class TransactionController extends Controller
{
    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($data['type'] == TransactionType::Expense->value) {
            $data['amount'] = -$data['amount'];
        }

        $transaction = $request->user()->transactions()->create($data);

        TransactionCreated::dispatch($transaction);

        return redirect()->back()->with('success', 'New transaction added.');
    }

    public function update(UpdateRequest $request, Transaction $transaction)
    {
        Gate::authorize('update', $transaction);

        $data = $request->validated();

        if ($data['type'] == TransactionType::Expense->value) {
            $data['amount'] = -$data['amount'];
        }

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
