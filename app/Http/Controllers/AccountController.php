<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $accounts = auth()->user()->accounts;
        $accountsData = $accounts->map(function ($account) {
            return [
                'account' => $account,
                'stats' => $this->getAccountStats($account),
                'monthlyActivity' => $this->getMonthlyActivity($account),
                'lastTransaction' => $this->getLastTransaction($account),
                'monthlyChange' => $this->calculateMonthlyChange($account)
            ];
        });

        return view('accounts.index', compact('accountsData'));
    }

    private function getAccountStats(Account $account)
    {
        $currentMonth = now()->month;

        return [
            'monthlyIncome' => $account->transactions()
                ->where('type', 'income')
                ->whereMonth('date', $currentMonth)
                ->sum('amount'),

            'monthlyExpenses' => $account->transactions()
                ->where('type', 'expense')
                ->whereMonth('date', $currentMonth)
                ->sum('amount'),
        ];
    }

    private function getMonthlyActivity(Account $account)
    {
        return [
            'isActive' => $account->transactions()
                ->whereMonth('date', now()->month)
                ->exists(),
        ];
    }

    private function getLastTransaction(Account $account)
    {
        return $account->transactions()
            ->latest()
            ->first();
    }

    private function calculateMonthlyChange(Account $account)
    {
        $thisMonth = now();
        $lastMonth = now()->subMonth();

        $thisMonthNet = $this->getMonthlyNetChange($account, $thisMonth);
        $lastMonthNet = $this->getMonthlyNetChange($account, $lastMonth);

        return [
            'thisMonthNet' => $thisMonthNet,
            'lastMonthNet' => $lastMonthNet,
            'percentageChange' => $this->calculatePercentageChange($thisMonthNet, $lastMonthNet),
        ];
    }

    private function getMonthlyNetChange(Account $account, Carbon $date)
    {
        return $account->transactions()
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE -amount END) as net_change', ['income'])
            ->value('net_change') ?? 0;
    }

    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / abs($previous)) * 100;
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:checking,savings,credit',
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3'
        ]);

        auth()->user()->accounts()->create($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account created successfully.');
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account);

        $transactions = $account
            ->transactions()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('accounts.show', compact('account', 'transactions'));
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:checking,savings,credit',
            'currency' => 'required|string|size:3'
        ]);

        $account->update($validated);

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account updated successfully.');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        $account->delete();

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Account deleted successfully.');
    }
}
