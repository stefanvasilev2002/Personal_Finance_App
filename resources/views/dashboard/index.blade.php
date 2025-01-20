<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Financial Overview') }}
        </h2>
    </x-slot>
    <x-slot name="slot">

        <div class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Balance -->
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200">Total Balance</h3>
                            <p class="text-3xl font-bold mt-2 {{ $totalBalance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                ${{ number_format($totalBalance, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Account Count -->
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200">Active Accounts</h3>
                            <p class="text-3xl font-bold mt-2 text-blue-400">
                                {{ $accounts->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200 mb-4">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('transactions.create') }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                    New Transaction
                                </a>
                                <a href="{{ route('accounts.create') }}" class="block w-full text-center border border-gray-600 hover:bg-gray-700 text-gray-200 font-semibold py-2 px-4 rounded">
                                    Add Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Accounts List -->
                @if($accounts->count() > 0)
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200 mb-4">Your Accounts</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($accounts as $account)
                                    <div class="border border-gray-700 rounded-lg p-4 bg-gray-800">
                                        <h4 class="font-medium text-gray-200">{{ $account->name }}</h4>
                                        <p class="text-sm text-gray-400">{{ ucfirst($account->type) }}</p>
                                        <p class="text-xl font-bold mt-2 {{ $account->balance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                            ${{ number_format($account->balance, 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Transactions -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-200 mb-4">Recent Transactions</h3>
                        @if($recentTransactions->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTransactions as $transaction)
                                    <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                                        <div>
                                            <p class="font-medium text-gray-200">{{ $transaction->description }}</p>
                                            <p class="text-sm text-gray-400">{{ $transaction->date->format('M d, Y') }}</p>
                                        </div>
                                        <p class="font-semibold {{ $transaction->type === 'income' ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}
                                            ${{ number_format($transaction->amount, 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-4">No recent transactions</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
