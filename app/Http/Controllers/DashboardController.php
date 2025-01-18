<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\FinancialGoal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $accounts = $user->accounts;
        $totalBalance = $accounts->sum('balance');

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

        return view('dashboard', compact(
            'accounts',
            'totalBalance',
            'recentTransactions',
            'budgets',
            'goals'
        ));
    }
}
