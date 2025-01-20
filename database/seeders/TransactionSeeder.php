<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $accounts = $user->accounts;
            $incomeCategories = Category::where('user_id', $user->id)
                ->where('type', 'income')
                ->get();
            $expenseCategories = Category::where('user_id', $user->id)
                ->where('type', 'expense')
                ->get();

            // Only proceed if we have categories
            if ($incomeCategories->count() > 0 && $expenseCategories->count() > 0) {
                foreach ($accounts as $account) {
                    // Create income transactions
                    for ($i = 0; $i < 3; $i++) {
                        Transaction::create([
                            'account_id' => $account->id,
                            'category_id' => $incomeCategories->random()->id,
                            'amount' => rand(1000, 5000),
                            'type' => 'income',
                            'description' => 'Monthly Income ' . ($i + 1),
                            'date' => Carbon::now()->subDays(rand(1, 30)),
                            'is_recurring' => true,
                        ]);
                    }

                    // Create expense transactions
                    for ($i = 0; $i < 5; $i++) {
                        Transaction::create([
                            'account_id' => $account->id,
                            'category_id' => $expenseCategories->random()->id,
                            'amount' => rand(10, 1000),
                            'type' => 'expense',
                            'description' => 'Expense ' . ($i + 1),
                            'date' => Carbon::now()->subDays(rand(1, 30)),
                            'is_recurring' => false,
                        ]);
                    }
                }
            }
        }
    }
}
