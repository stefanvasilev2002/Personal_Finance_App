<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accounts') }}
            </h2>
            <a href="{{ route('accounts.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                New Account
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="p-4 mb-4 text-sm rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400 border border-green-400/30">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($accounts as $account)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>

                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $account->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ ucfirst($account->type) }}
                                    </p>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.edit', $account) }}"
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                    <form action="{{ route('accounts.destroy', $account) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure? This will also delete all associated transactions.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="h-2 w-2 rounded-full {{ $account->transactions()->whereMonth('date', now()->month)->exists() ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $account->transactions()->whereMonth('date', now()->month)->exists() ? 'Active this month' : 'Inactive this month' }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="text-2xl font-bold {{ $account->balance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $account->currency }} {{ number_format($account->balance, 2) }}
                                </p>
                            </div>
                            <div class="mt-4 flex space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span>Income:</span>
                                    <span class="text-green-400">+${{ number_format($account->transactions()->where('type', 'income')->whereMonth('date', now()->month)->sum('amount'), 2) }}</span>
                                </div>
                                <div>
                                    <span>Expenses:</span>
                                    <span class="text-red-400">-${{ number_format($account->transactions()->where('type', 'expense')->whereMonth('date', now()->month)->sum('amount'), 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('accounts.show', $account) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                                    View Transactions →
                                </a>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="{{ route('transactions.create', ['account' => $account->id]) }}"
                                   class="text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
                                    Add Transaction
                                </a>
                                <button onclick="document.getElementById('transfer-form-{{ $account->id }}').classList.toggle('hidden')"
                                        class="text-center border border-gray-600 hover:bg-gray-700 text-gray-200 text-sm font-medium py-2 px-4 rounded">
                                    Transfer
                                </button>
                            </div>

                            <!-- Quick Transfer Form -->
                            <div id="transfer-form-{{ $account->id }}" class="hidden mt-4 p-4 bg-gray-700 rounded">
                                <form action="{{ route('transfers.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="from_account_id" value="{{ $account->id }}">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm text-gray-400">To Account</label>
                                            <select name="to_account_id" required
                                                    class="mt-1 block w-full rounded-md border-gray-600 bg-gray-800 text-gray-300">
                                                @foreach(auth()->user()->accounts->where('id', '!=', $account->id) as $toAccount)
                                                    <option value="{{ $toAccount->id }}">{{ $toAccount->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm text-gray-400">Amount</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500">$</span>
                                                </div>
                                                <input type="number" name="amount" step="0.01" min="0.01" required
                                                       class="pl-7 block w-full rounded-md border-gray-600 bg-gray-800 text-gray-300">
                                            </div>
                                        </div>
                                        <button type="submit"
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                                            Transfer
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-400">Last Transaction</p>
                                        @if($lastTransaction = $account->transactions()->latest()->first())
                                            <p class="text-gray-200">{{ $lastTransaction->date->format('M d, Y') }}</p>
                                        @else
                                            <p class="text-gray-500">No transactions</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Monthly Change</p>
                                        @php
                                            $thisMonthNet = $account->transactions()
                                                ->whereMonth('date', now()->month)
                                                ->whereYear('date', now()->year)
                                                ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE -amount END) as net_change', ['income'])
                                                ->value('net_change') ?? 0;

                                            $lastMonthNet = $account->transactions()
                                                ->whereMonth('date', now()->subMonth()->month)
                                                ->whereYear('date', now()->subMonth()->year)
                                                ->selectRaw('SUM(CASE WHEN type = ? THEN amount ELSE -amount END) as net_change', ['income'])
                                                ->value('net_change') ?? 0;

                                            $percentChange = $lastMonthNet != 0
                                                ? (($thisMonthNet - $lastMonthNet) / abs($lastMonthNet)) * 100
                                                : ($thisMonthNet > 0 ? 100 : 0);
                                        @endphp
                                        <p class="text-{{ $percentChange >= 0 ? 'green' : 'red' }}-400">
                                            {{ $percentChange >= 0 ? '+' : '' }}{{ number_format($percentChange, 1) }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-3">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-center">
                                <p class="text-gray-600 dark:text-gray-400">No accounts found.</p>
                                <a href="{{ route('accounts.create') }}"
                                   class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create Your First Account
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
