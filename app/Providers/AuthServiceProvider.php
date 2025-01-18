<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\FinancialGoal;
use App\Policies\AccountPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\BudgetPolicy;
use App\Policies\FinancialGoalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Account::class => AccountPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Budget::class => BudgetPolicy::class,
        FinancialGoal::class => FinancialGoalPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
