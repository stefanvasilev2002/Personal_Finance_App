<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialGoal;
use App\Models\User;

class FinancialGoalSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Emergency Fund Goal
            FinancialGoal::create([
                'user_id' => $user->id,
                'name' => 'Emergency Fund',
                'target_amount' => 10000.00,
                'current_amount' => 2500.00,
                'target_date' => now()->addMonths(6),
                'type' => 'emergency_fund',
                'status' => 'in_progress',
            ]);

            // Vacation Fund Goal
            FinancialGoal::create([
                'user_id' => $user->id,
                'name' => 'Summer Vacation',
                'target_amount' => 5000.00,
                'current_amount' => 1000.00,
                'target_date' => now()->addMonths(8),
                'type' => 'vacation',
                'status' => 'in_progress',
            ]);

            // Down Payment Goal
            FinancialGoal::create([
                'user_id' => $user->id,
                'name' => 'House Down Payment',
                'target_amount' => 50000.00,
                'current_amount' => 15000.00,
                'target_date' => now()->addYears(2),
                'type' => 'down_payment',
                'status' => 'in_progress',
            ]);
        }
    }
}
