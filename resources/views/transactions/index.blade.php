<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                New Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form action="{{ route('transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Date Range</label>
                        <select name="date_range" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">All Time</option>
                            <option value="today" {{ request('date_range') === 'today' ? 'selected' : '' }}>Today</option>
                            <option value="week" {{ request('date_range') === 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('date_range') === 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="year" {{ request('date_range') === 'year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>

                    <!-- Account Filter -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Account</label>
                        <select name="account" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">All Accounts</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ request('account') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Type</label>
                        <select name="type" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="">All Types</option>
                            <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="col-span-full flex justify-end space-x-2">
                        <a href="{{ route('transactions.index') }}"
                           class="px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                            Clear Filters
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Summary Cards -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Income Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Income</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">
                        ${{ number_format($totalIncome, 2) }}
                    </p>
                </div>
            </div>

            <!-- Expense Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expenses</h3>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">
                        ${{ number_format($totalExpenses, 2) }}
                    </p>
                </div>
            </div>

            <!-- Net Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Net Balance</h3>
                    <p class="text-2xl font-bold {{ $netBalance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                        ${{ number_format($netBalance, 2) }}
                    </p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 text-sm rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400 border border-green-400/30">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($transactions->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400 text-center py-6">
                            No transactions found. Start by creating a new transaction.
                        </p>
                    @else

                        <div class="overflow-x-auto relative">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Date</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Account</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Category</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Description</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Type</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Amount</th>
                                    <th scope="col" class="py-3 px-6 whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            {{ $transaction->date->format('Y-m-d') }}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap max-w-[150px] truncate">
                                            {{ $transaction->account->name }}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap flex items-center gap-2 max-w-[150px]">
                                            <span class="">{{ $transaction->category->name }}</span>
                                            <i class="fas fa-{{ $transaction->category->icon }} text-sm flex-shrink-0"
                                               style="color: {{ $transaction->category->color }}"></i>
                                        </td>
                                        <td class="py-4 px-6 max-w-[200px] truncate">
                                            {{ $transaction->description ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $transaction->type === 'income'
                            ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                            : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                        {{ ucfirst($transaction->type) }}
                    </span>
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap font-medium
                    {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->account->currency }} {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('transactions.edit', $transaction) }}"
                                                   class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    Edit
                                                </a>
                                                <form action="{{ route('transactions.destroy', $transaction) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this transaction?');"
                                                      class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 dark:text-red-400 hover:underline">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
