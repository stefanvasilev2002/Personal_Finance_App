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

        $selectedDate = request()->get('insight_date')
            ? Carbon::createFromFormat('Y-m', request()->get('insight_date'))
            : now();

        $topCategories = $this->getCategoryStats($accounts, $selectedDate);

        $monthlyIncome = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('type', 'income')
            ->whereYear('date', $selectedDate->year)
            ->whereMonth('date', $selectedDate->month)
            ->sum('amount');

        $monthlyExpenses = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('type', 'expense')
            ->whereYear('date', $selectedDate->year)
            ->whereMonth('date', $selectedDate->month)
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
            if ($budget->isOverBudget() && $budget->end_date > Carbon::now() ) {
                $alerts->push([
                    'type' => 'error',
                    'message' => "Budget alert: {$budget->category->name} has exceeded the monthly limit"
                ]);
            }
        }
        $upcomingRecurring = Transaction::where('is_recurring', true)
            ->whereBetween('date', [now(), now()->addDays(7)])
            ->get();

        foreach ($upcomingRecurring as $transaction) {
            $alerts->push([
                'type' => 'warning',
                'message' => "Upcoming recurring {$transaction->type}: {$transaction->description} - $" .
                    number_format($transaction->amount, 2) .
                    " due " . $transaction->date->format('M d, Y')
            ]);
        }

        $now = Carbon::now();
        $nextMonth = $now->copy()->addMonth()->startOfMonth();
        $daysUntilNextMonth = $now->diffInDays($nextMonth);

        $upcomingBills = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->where('is_recurring', true)
            ->where('type', 'expense')
            ->with(['category'])
            ->get()
            ->map(function ($transaction) use ($daysUntilNextMonth) {
                return [
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'due_days' => $daysUntilNextMonth,
                    'category' => $transaction->category
                ];
            })
            ->sortBy('due_days')
            ->take(5);

        $months = request()->get('months', 6);
        $monthlyStats = $this->getMonthlyStats($accounts, $months);

        return view('dashboard.index', compact(
            'accounts',
            'totalBalance',
            'recentTransactions',
            'budgets',
            'goals',
            'topCategories',
            'savingsRate',
            'alerts',
            'upcomingBills',
            'monthlyStats',
            'months',
            'selectedDate',
            'monthlyIncome',
            'monthlyExpenses'
        ));
    }
    private function getCategoryStats($accounts, $date)
    {
        return Category::whereHas('transactions', function ($query) use ($accounts, $date) {
            $query->whereIn('account_id', $accounts->pluck('id'))
                ->where('type', 'expense')
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month);
        })
            ->withSum(['transactions as total' => function ($query) use ($accounts, $date) {
                $query->whereIn('account_id', $accounts->pluck('id'))
                    ->where('type', 'expense')
                    ->whereYear('date', $date->year)
                    ->whereMonth('date', $date->month);
            }], 'amount')
            ->orderByDesc('total')
            ->take(5)
            ->get();
    }
    private function getMonthlyStats($accounts, $months = 6)
    {
        $stats = [];
        for ($i = 0; $i < $months; $i++) {
            $date = now()->subMonths($i);

            $income = Transaction::whereIn('account_id', $accounts->pluck('id'))
                ->where('type', 'income')
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $expenses = Transaction::whereIn('account_id', $accounts->pluck('id'))
                ->where('type', 'expense')
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');

            $savingsRate = $income > 0 ? (($income - $expenses) / $income) * 100 : 0;

            $stats[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expenses' => $expenses,
                'savings' => $income - $expenses,
                'savingsRate' => round($savingsRate, 2)
            ];
        }

        return array_reverse($stats);
    }
}
