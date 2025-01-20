<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $accounts = $user->accounts;
        $totalBalance = $accounts->sum('balance');
        $accountIds = $accounts->pluck('id');

        $recentTransactions = Transaction::whereIn('account_id', $accounts->pluck('id'))
            ->with(['account', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $budgets = $user->budgets()
            ->with('category')
            ->whereMonth('start_date', now()->month)
            ->get();

        $goals = $user->financialGoals;


        return view('dashboard.index', compact(
            'accounts',
            'totalBalance',
            'recentTransactions',
            'budgets',
            'goals'
        ));
    }
}
