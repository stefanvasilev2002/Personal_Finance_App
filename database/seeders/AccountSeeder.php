<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Create checking account
            Account::create([
                'user_id' => $user->id,
                'name' => 'Main Checking',
                'type' => 'checking',
                'balance' => 5000.00,
                'currency' => 'USD',
            ]);

            // Create savings account
            Account::create([
                'user_id' => $user->id,
                'name' => 'Savings',
                'type' => 'savings',
                'balance' => 10000.00,
                'currency' => 'USD',
            ]);

            // Create credit card account
            Account::create([
                'user_id' => $user->id,
                'name' => 'Credit Card',
                'type' => 'credit',
                'balance' => -1500.00,
                'currency' => 'USD',
            ]);
        }
    }
}
