<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $accounts = $user->accounts;
        $totalBalance = $accounts->sum('balance');
        $accountIds = $accounts->pluck('id');

        $recentTransactions = Transaction::whereIn('account_id', $accountIds)
            ->with(['account', 'category'])
            ->latest()
            ->take(6)
            ->get();

        $budgets = $user->budgets()
            ->with('category')
            ->whereMonth('start_date', now()->month)
            ->get();

        $goals = $user->financialGoals;

        $topCategories = Category::whereHas('transactions', function ($query) use ($accounts) {
            $query->whereIn('account_id', $accounts->pluck('id'))
                ->where('type', 'expense')
                ->whereMonth('date', now()->month);
        })
            ->withSum(['transactions as total' => function ($query) use ($accounts) {
                $query->whereIn('account_id', $accounts->pluck('id'))
                    ->where('type', 'expense')
                    ->whereMonth('date', now()->month);
            }], 'amount')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $monthlyIncome = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('type', 'income')
            ->whereMonth('date', now()->month)
            ->sum('amount');

        $monthlyExpenses = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('type', 'expense')
            ->whereMonth('date', now()->month)
            ->sum('amount');

        $savingsRate = $monthlyIncome > 0
            ? (($monthlyIncome - $monthlyExpenses) / $monthlyIncome) * 100
            : 0;
        $savingsRate = round($savingsRate, 2);

        $alerts = collect();

        foreach ($accounts as $account) {
            if ($account->balance < 100) {
                $alerts->push([
                    'type' => 'warning',
                    'message' => "Low balance alert: {$account->name} is below $100"
                ]);
            }
        }

        foreach ($user->budgets as $budget) {
            if ($budget->isOverBudget()) {
                $alerts->push([
                    'type' => 'error',
                    'message' => "Budget alert: {$budget->category->name} has exceeded the monthly limit"
                ]);
            }
        }

        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth()->startOfMonth();
        $daysUntilNextMonth = $now->diffInDays($nextMonth);

        $upcomingBills = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('is_recurring', true)
            ->where('type', 'expense')
            ->get()
            ->map(function ($transaction) use ($daysUntilNextMonth) {
                return [
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'due_days' => $daysUntilNextMonth
                ];
            })
            ->sortBy('due_days')
            ->take(5);

        return view('dashboard.index', compact(
            'accounts',
            'totalBalance',
            'recentTransactions',
            'budgets',
            'goals',
            'topCategories',
            'savingsRate',
            'alerts',
            'upcomingBills'
        ));
    }
}
