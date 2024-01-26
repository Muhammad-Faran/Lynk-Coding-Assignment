<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class UpdateOverdueTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:update-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of overdue transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating overdue transactions...');

        // Get transactions that are not fully paid and are overdue
        $overdueTransactions = Transaction::where('status', '<>', 'Paid')
            ->where('due_on', '<', now()->format('Y-m-d'))
            ->get();

        foreach ($overdueTransactions as $transaction) {
            // Update the status to 'Overdue'
            $transaction->update(['status' => 'Overdue']);
        }

        $this->info('Overdue transactions updated successfully.');
    }
}
