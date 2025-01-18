<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $categories = [
            // Income categories
            ['name' => 'Salary', 'type' => 'income', 'color' => '#28a745', 'icon' => 'briefcase'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#17a2b8', 'icon' => 'laptop'],
            ['name' => 'Investments', 'type' => 'income', 'color' => '#ffc107', 'icon' => 'trending-up'],

            // Expense categories
            ['name' => 'Housing', 'type' => 'expense', 'color' => '#dc3545', 'icon' => 'home'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#6c757d', 'icon' => 'car'],
            ['name' => 'Food', 'type' => 'expense', 'color' => '#fd7e14', 'icon' => 'shopping-cart'],
            ['name' => 'Utilities', 'type' => 'expense', 'color' => '#20c997', 'icon' => 'zap'],
            ['name' => 'Healthcare', 'type' => 'expense', 'color' => '#e83e8c', 'icon' => 'heart'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#6f42c1', 'icon' => 'film'],
        ];

        foreach ($categories as $category) {
            $category['user_id'] = $user->id;
            Category::create($category);
        }
    }
}
