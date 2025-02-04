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
                    <div class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm" id="alertsContainer">
                        @foreach($alerts as $alert)
                            <div class="pl-2 p-3 rounded-lg flex justify-between items-center backdrop-blur-sm bg-opacity-90 shadow-lg transform transition-all duration-300 {{ $alert['type'] === 'error' ? 'bg-red-900/75 text-red-100' : 'bg-yellow-900/75 text-yellow-100' }}"
                                 role="alert"
                                 style="backdrop-filter: blur(8px);">
                                <span class="text-sm">{{ $alert['message'] }}</span>
                                <button class="dismiss-alert ml-3 hover:opacity-75 focus:outline-none"
                                        onclick="dismissAlert(this.parentElement)">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        alertElement.style.transform = 'translateX(100px)';
                        setTimeout(() => {
                            alertElement.remove();
                            if (document.querySelectorAll('#alertsContainer > div').length === 0) {
                                document.getElementById('alertsContainer').remove();
                            }
                        }, 300);
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        const alerts = document.querySelectorAll('[role="alert"]');
                        alerts.forEach((alert, index) => {
                            alert.style.transition = 'opacity 300ms, transform 300ms';
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateX(100px)';

                            setTimeout(() => {
                                alert.style.opacity = '1';
                                alert.style.transform = 'translateX(0)';
                            }, index * 150);

                            setTimeout(() => {
                                if (alert.isConnected) {
                                    dismissAlert(alert);
                                }
                            }, 5000 + (index * 150));
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

                <!-- Upcoming Incomes Section -->
                @if($upcomingIncomes->count() > 0)
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-200 mb-6">Upcoming Income</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($upcomingIncomes as $income)
                                    <div class="border border-gray-700 rounded-lg p-4 bg-gray-800 hover:bg-gray-750 transition-colors">
                                        <!-- Income Type Indicator -->
                                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-green-400">
                                Recurring Income
                            </span>
                                            <span class="px-2 py-1 bg-blue-900 text-blue-200 text-xs rounded">
                                Expected in {{ round($income['due_days'], mode: PHP_ROUND_HALF_DOWN) }} days
                            </span>
                                        </div>

                                        <!-- Amount -->
                                        <p class="text-xl font-bold text-green-400">
                                            +${{ number_format($income['amount'], 2) }}
                                        </p>

                                        <!-- Description -->
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-400">{{ $income['description'] }}</p>
                                        </div>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                                                 style="background-color: {{ $income['category']->color }}20">
                                                <i class="fas fa-{{ $income['category']->icon }} text-sm"
                                                   style="color: {{ $income['category']->color }}"></i>
                                            </div>
                                            <span class="text-sm text-gray-400">{{ $income['category']['name'] }}</span>
                                        </div>
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
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-200">Financial Insights</h3>
                            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                                <!-- Preserve other query parameters -->
                                @if(request()->has('months'))
                                    <input type="hidden" name="months" value="{{ request('months') }}">
                                @endif

                                <label for="insight_date" class="text-sm text-gray-400">View for</label>
                                <input
                                    type="month"
                                    id="insight_date"
                                    name="insight_date"
                                    value="{{ $selectedDate->format('Y-m') }}"
                                    max="{{ now()->format('Y-m') }}"
                                    class="bg-gray-700 text-gray-200 rounded-md text-sm p-1 border-gray-600"
                                    onchange="this.form.submit()"
                                >
                            </form>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Monthly Spending Trend -->
                            <div class="border border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-gray-200">Top Spending Categories</h4>
                                    <span class="text-sm text-gray-400">{{ $selectedDate->format('F Y') }}</span>
                                </div>
                                @if($topCategories->isNotEmpty())
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
                                @else
                                    <p class="text-gray-400 text-center py-4">No spending data for this month</p>
                                @endif
                            </div>

                            <div class="border border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-gray-200">Monthly Summary</h4>
                                    <span class="text-sm text-gray-400">{{ $selectedDate->format('F Y') }}</span>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-400">Monthly Income</p>
                                        <p class="text-xl text-green-400">${{ number_format($monthlyIncome, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Monthly Expenses</p>
                                        <p class="text-xl text-red-400">${{ number_format($monthlyExpenses, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Monthly Savings</p>
                                        <p class="text-xl text-blue-400">${{ number_format($monthlyIncome - $monthlyExpenses, 2) }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm text-gray-400">Savings Rate</h4>
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
                <!-- Historical Trends Section -->
                <div class="mt-6 bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-200">Historical Trends</h3>
                            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                                <label for="months" class="text-sm text-gray-400">Show last</label>
                                <select name="months" id="months" class="bg-gray-700 text-gray-200 rounded-md text-sm p-1" onchange="this.form.submit()">
                                    @foreach([3, 6, 12, 24] as $monthOption)
                                        <option value="{{ $monthOption }}" {{ $months == $monthOption ? 'selected' : '' }}>
                                            {{ $monthOption }} months
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        @if(count($monthlyStats) > 0)
                            <!-- Trends Chart -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Chart -->
                                <div class="relative" style="height: 300px;">
                                    <canvas id="trendsChart"></canvas>
                                </div>

                                <!-- Monthly Summary -->
                                <div class="border border-gray-700 rounded-lg p-4">
                                    <h4 class="text-gray-200 mb-4">Monthly Summary</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-400">Average Monthly Income</p>
                                            <p class="text-xl text-green-400">${{ number_format(collect($monthlyStats)->avg('income'), 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-400">Average Monthly Expenses</p>
                                            <p class="text-xl text-red-400">${{ number_format(collect($monthlyStats)->avg('expenses'), 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-400">Average Monthly Savings</p>
                                            <p class="text-xl text-blue-400">${{ number_format(collect($monthlyStats)->avg('savings'), 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-400">Average Savings Rate</p>
                                            <p class="text-xl text-purple-400">{{ number_format(collect($monthlyStats)->avg('savingsRate'), 1) }}%</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trends Table -->
                            <div class="mt-6 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Month</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Income</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Expenses</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Savings</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Savings Rate</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                    @foreach($monthlyStats as $stat)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">{{ $stat['month'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">${{ number_format($stat['income'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">${{ number_format($stat['expenses'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-400">${{ number_format($stat['savings'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-400">{{ number_format($stat['savingsRate'], 1) }}%</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-400 text-center py-4">No historical data available</p>
                        @endif
                    </div>
                </div>
                @push('scripts')
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('trendsChart').getContext('2d');
                            const stats = @json($monthlyStats);

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: stats.map(stat => stat.month),
                                    datasets: [
                                        {
                                            label: 'Income',
                                            data: stats.map(stat => stat.income),
                                            borderColor: '#22c55e',
                                            tension: 0.1
                                        },
                                        {
                                            label: 'Expenses',
                                            data: stats.map(stat => stat.expenses),
                                            borderColor: '#ef4444',
                                            tension: 0.1
                                        },
                                        {
                                            label: 'Savings',
                                            data: stats.map(stat => stat.savings),
                                            borderColor: '#3b82f6',
                                            tension: 0.1
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        mode: 'index',
                                        intersect: false,
                                    },
                                    plugins: {
                                        legend: {
                                            labels: {
                                                color: '#e5e7eb'
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                color: '#374151'
                                            },
                                            ticks: {
                                                color: '#9ca3af'
                                            }
                                        },
                                        y: {
                                            grid: {
                                                color: '#374151'
                                            },
                                            ticks: {
                                                color: '#9ca3af',
                                                callback: function(value) {
                                                    return '$' + value.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                @endpush
            </div>
        </div>
    </x-slot>
</x-app-layout>
