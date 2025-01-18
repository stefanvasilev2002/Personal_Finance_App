<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Account Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Account Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($accounts as $account)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium">{{ $account->name }}</h4>
                                <p class="text-2xl font-bold {{ $account->balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($account->balance, 2) }} {{ $account->currency }}
                                </p>
                                <p class="text-sm text-gray-500">{{ ucfirst($account->type) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Transactions</h3>
                            <a href="{{ route('transactions.create') }}" class="text-blue-600 hover:text-blue-800">Add New</a>
                        </div>
                        @foreach($recentTransactions as $transaction)
                            <div class="border-b border-gray-100 py-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium">{{ $transaction->description }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->category->name }}</p>
                                    </div>
                                    <p class="{{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}
                                        {{ number_format($transaction->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Budget Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Budget Overview</h3>
                            <a href="{{ route('budgets.create') }}" class="text-blue-600 hover:text-blue-800">Manage Budgets</a>
                        </div>
                        @foreach($budgets as $budget)
                            <div class="mb-4">
                                <div class="flex justify-between mb-1">
                                    <span>{{ $budget->category->name }}</span>
                                    <span>{{ $budget->spent ?? 0 }} / {{ $budget->amount }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $percentage = min(($budget->spent ?? 0) / $budget->amount * 100, 100);
                                        $colorClass = $percentage > 90 ? 'bg-red-600' : ($percentage > 70 ? 'bg-yellow-600' : 'bg-green-600');
                                    @endphp
                                    <div class="{{ $colorClass }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Financial Goals -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Financial Goals</h3>
                        <a href="{{ route('goals.create') }}" class="text-blue-600 hover:text-blue-800">Add Goal</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($goals as $goal)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium">{{ $goal->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $goal->type }}</p>
                                <div class="mt-2">
                                    <div class="flex justify-between mb-1 text-sm">
                                        <span>Progress</span>
                                        <span>{{ number_format(($goal->current_amount / $goal->target_amount) * 100, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                             style="width: {{ ($goal->current_amount / $goal->target_amount) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
