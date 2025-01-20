<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Budget;
use App\Models\User;

class BudgetSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $expenseCategories = $user->categories()->where('type', 'expense')->get();

            foreach ($expenseCategories as $category) {
                Budget::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => rand(500, 2000),
                    'start_date' => now()->startOfMonth(),
                    'end_date' => now()->endOfMonth(),
                ]);
            }
        }
    }
}
