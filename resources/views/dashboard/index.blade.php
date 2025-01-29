<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Financial Overview') }}
        </h2>
    </x-slot>
    <x-slot name="slot">
        <div class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Alerts Section -->
                @if($alerts->count() > 0)
                    <div class="mb-6" id="alertsContainer">
                        @foreach($alerts as $alert)
                            <div class="p-4 mb-2 rounded-lg flex justify-between items-center {{ $alert['type'] === 'error' ? 'bg-red-900 text-red-200' : 'bg-yellow-900 text-yellow-200' }}"
                                 role="alert">
                                <span>{{ $alert['message'] }}</span>
                                <button class="dismiss-alert ml-4 hover:opacity-75 focus:outline-none"
                                        onclick="dismissAlert(this.parentElement)">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <script>
                    function dismissAlert(alertElement) {
                        alertElement.style.opacity = '0';
                        alertElement.style.transform = 'translateX(-10px)';
                        setTimeout(() => {
                            alertElement.remove();
                            if (document.querySelectorAll('#alertsContainer > div').length === 0) {
                                document.getElementById('alertsContainer').remove();
                            }
                        }, 300);
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        const alerts = document.querySelectorAll('[role="alert"]');
                        alerts.forEach(alert => {
                            alert.style.transition = 'opacity 300ms, transform 300ms';
                        });
                    });
                </script>

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


                <!-- Upcoming Bills Section -->
                @if($upcomingBills->count() > 0)
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200 mb-6">Upcoming Bills</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($upcomingBills as $bill)
                                    <div class="border border-gray-700 rounded-lg p-4 bg-gray-800 hover:bg-gray-750 transition-colors">
                                        <!-- Bill Type Indicator -->
                                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-red-400">
                                Recurring Bill
                            </span>
                                            <span class="px-2 py-1 bg-blue-900 text-blue-200 text-xs rounded">
                                Due in {{ round($bill['due_days'], mode: PHP_ROUND_HALF_DOWN) }} days
                            </span>
                                        </div>

                                        <!-- Amount -->
                                        <p class="text-xl font-bold text-red-400">
                                            -${{ number_format($bill['amount'], 2) }}
                                        </p>

                                        <!-- Description -->
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-400">{{ $bill['description'] }}</p>
                                        </div>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                                                 style="background-color: {{ $bill['category']->color }}20">
                                                <i class="fas fa-{{ $bill['category']->icon }} text-sm"
                                                   style="color: {{ $bill['category']->color }}"></i>
                                            </div>
                                            <span class="text-sm text-gray-400">{{ $bill['category']['name'] }}</span>                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

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

                <!-- Recent Transactions Section -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                    <h3 class="text-gray-200 font-medium mb-6">Recent Transactions</h3>

                    @if($recentTransactions->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recentTransactions as $transaction)
                                <div class="border border-gray-700 rounded-lg p-4 bg-gray-800 hover:bg-gray-750 transition-colors">
                                    <!-- Transaction Type Indicator -->
                                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium {{ $transaction->type === 'income' ? 'text-green-400' : 'text-red-400' }}">
                            {{ ucfirst($transaction->type) }}
                        </span>
                                        @if($transaction->is_recurring)
                                            <span class="px-2 py-1 bg-blue-900 text-blue-200 text-xs rounded">
                                Recurring
                            </span>
                                        @endif
                                    </div>

                                    <!-- Amount -->
                                    <p class="text-xl font-bold {{ $transaction->type === 'income' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format(abs($transaction->amount), 2) }}
                                    </p>

                                    <!-- Date and Account -->
                                    <div class="mt-2 text-sm text-gray-400">
                                        <p>{{ $transaction->date->format('M d, Y') }}</p>
                                        <p>{{ $transaction->account->name }}</p>
                                    </div>

                                    <!-- Category with Icon -->
                                    <div class="mt-2 flex items-center">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                                             style="background-color: {{ $transaction->category->color }}20">
                                            <i class="fas fa-{{ $transaction->category->icon }} text-sm"
                                               style="color: {{ $transaction->category->color }}"></i>
                                        </div>
                                        <span class="text-sm text-gray-400">{{ $transaction->category->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4">No recent transactions</p>
                    @endif
                </div>

                <!-- Financial Insights -->
                <div class="mt-6 bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-200 mb-4">Financial Insights</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Monthly Spending Trend -->
                            <div class="border border-gray-700 rounded-lg p-4">
                                <h4 class="text-gray-200 mb-2">Top Spending Categories</h4>
                                @foreach($topCategories as $category)
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                                                 style="background-color: {{ $category->color }}20">
                                                <i class="fas fa-{{ $category->icon }} text-sm"
                                                   style="color: {{ $category->color }}"></i>
                                            </div>
                                            <span class="text-gray-400">{{ $category->name }}</span>
                                        </div>
                                        <span class="text-red-400">${{ number_format($category->total, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border border-gray-700 rounded-lg p-4">
                                <h4 class="text-gray-200 mb-2">Monthly Savings Rate</h4>
                                <div class="flex items-end space-x-2">
                                    <span class="text-2xl text-green-400">{{ $savingsRate }}%</span>
                                    <span class="text-gray-400 text-sm">of income</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2.5 mt-2">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $savingsRate }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
