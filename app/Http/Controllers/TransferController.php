<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_account_id' => 'required|exists:accounts,id',
            'to_account_id' => 'required|exists:accounts,id|different:from_account_id',
            'amount' => 'required|numeric|min:0.01'
        ]);

        DB::transaction(function () use ($validated) {
            $fromAccount = Account::findOrFail($validated['from_account_id']);
            $toAccount = Account::findOrFail($validated['to_account_id']);

            // Get or create transfer category with user_id
            $transferCategory = Category::firstOrCreate(
                [
                    'name' => 'Transfers',
                    'user_id' => auth()->id()
                ],
                [
                    'type' => 'transfer' // Add any other default attributes
                ]
            );

            // Create withdrawal transaction
            $fromAccount->transactions()->create([
                'type' => 'expense',
                'amount' => $validated['amount'],
                'description' => 'Transfer to ' . $toAccount->name,
                'date' => now(),
                'category_id' => $transferCategory->id
            ]);

            // Create deposit transaction
            $toAccount->transactions()->create([
                'type' => 'income',
                'amount' => $validated['amount'],
                'description' => 'Transfer from ' . $fromAccount->name,
                'date' => now(),
                'category_id' => $transferCategory->id
            ]);

            // Update account balances
            $fromAccount->decrement('balance', $validated['amount']);
            $toAccount->increment('balance', $validated['amount']);
        });

        return back()->with('success', 'Transfer completed successfully.');
    }
}
