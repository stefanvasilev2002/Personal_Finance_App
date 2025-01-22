<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        $this->call(CategorySeeder::class);

        $this->call(AccountSeeder::class);

        $this->call(TransactionSeeder::class);

        $this->call(BudgetSeeder::class);

        $this->call(FinancialGoalSeeder::class);
    }
}
