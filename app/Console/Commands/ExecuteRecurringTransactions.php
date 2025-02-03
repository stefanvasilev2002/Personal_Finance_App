<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExecuteRecurringTransactions extends Command
{
    protected $signature = 'transactions:execute-recurring';
    protected $description = 'Execute due recurring transactions';

    public function handle()
    {
        $this->info('Starting recurring transactions execution...');

        // Get due transactions
        $dueTransactions = Transaction::where('is_recurring', true)
            ->where('date', '<=', now())
            ->get();

        $this->info("Found {$dueTransactions->count()} due transactions");

        $executed = 0;
        foreach ($dueTransactions as $transaction) {
            try {
                $this->line("Processing transaction: {$transaction->description} (ID: {$transaction->id})");

                $newTransaction = $transaction->executeRecurring();

                if ($newTransaction) {
                    $executed++;
                    $this->info("✓ Executed: {$transaction->description}");
                    $this->line("  Amount: \${$newTransaction->amount}");
                    $this->line("  New ID: {$newTransaction->id}");
                    $this->line("  Next date: {$transaction->date->format('Y-m-d')}");

                    \Log::info("Recurring transaction executed", [
                        'original_id' => $transaction->id,
                        'new_id' => $newTransaction->id,
                        'amount' => $newTransaction->amount,
                        'next_date' => $transaction->date
                    ]);
                }
            } catch (\Exception $e) {
                $this->error("Failed to process transaction {$transaction->id}: {$e->getMessage()}");
                \Log::error("Failed to execute recurring transaction", [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->newLine();
        $this->info("Completed! Executed {$executed} recurring transactions");
    }
}
