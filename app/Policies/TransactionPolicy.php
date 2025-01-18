<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Transaction $transaction): bool
    {
        return $user->accounts->contains($transaction->account_id);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $user->accounts->contains($transaction->account_id);
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->accounts->contains($transaction->account_id);
    }
}
