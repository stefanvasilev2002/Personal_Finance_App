<?php

namespace App\Policies;

use App\Models\FinancialGoal;
use App\Models\User;

class FinancialGoalPolicy
{
    public function view(User $user, FinancialGoal $financialGoal)
    {
        return $user->id === $financialGoal->user_id;
    }

    public function update(User $user, FinancialGoal $financialGoal)
    {
        return $user->id === $financialGoal->user_id;
    }

    public function delete(User $user, FinancialGoal $financialGoal)
    {
        return $user->id === $financialGoal->user_id;
    }
}
