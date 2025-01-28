<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Transaction::whereIn('account_id', $user->accounts->pluck('id'))
            ->with(['account', 'category']);

        if ($request->filled('date_range')) {
            $query->when($request->date_range === 'today', function ($q) {
                return $q->whereDate('date', today());
            })->when($request->date_range === 'week', function ($q) {
                return $q->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
            })->when($request->date_range === 'month', function ($q) {
                return $q->whereMonth('date', now()->month)->whereYear('date', now()->year);
            })->when($request->date_range === 'year', function ($q) {
                return $q->whereYear('date', now()->year);
            });
        }

        if ($request->filled('account')) {
            $query->where('account_id', $request->account);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpenses = (clone $query)->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;

        $transactions = $query->latest()->paginate(15)->withQueryString();

        $accounts = $user->accounts;
        $categories = $user->categories;

        return view('transactions.index', compact(
            'transactions',
            'accounts',
            'categories',
            'totalIncome',
            'totalExpenses',
            'netBalance'
        ));
    }

    public function create()
    {
        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories;

        return view('transactions.create',
            compact('accounts', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'is_recurring' => 'boolean'
        ]);

        $account = auth()->user()->accounts()->findOrFail($validated['account_id']);

        $transaction = Transaction::create($validated);

        if ($validated['type'] === 'income') {
            $account->increment('balance', $validated['amount']);
        } else {
            $account->decrement('balance', $validated['amount']);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $accounts = auth()->user()->accounts;
        $categories = auth()->user()->categories;

        return view('transactions.edit', compact('transaction', 'accounts', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            'is_recurring' => 'boolean'
        ]);

        if ($transaction->type === 'income') {
            $transaction->account->decrement('balance', $transaction->amount);
        } else {
            $transaction->account->increment('balance', $transaction->amount);
        }

        $transaction->update($validated);

        if ($validated['type'] === 'income') {
            $transaction->account->increment('balance', $validated['amount']);
        } else {
            $transaction->account->decrement('balance', $validated['amount']);
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        if ($transaction->type === 'income') {
            $transaction->account->decrement('balance', $transaction->amount);
        } else {
            $transaction->account->increment('balance', $transaction->amount);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
