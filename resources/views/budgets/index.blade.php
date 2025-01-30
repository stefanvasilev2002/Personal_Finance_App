<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Expense Budgets') }}
            </h2>
            <a href="{{ route('budgets.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Budget
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400 border border-green-400/30">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-lg bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400 border border-red-400/30">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Budget</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            ${{ number_format($totalBudget, 2) }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expenses</h3>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                            ${{ number_format($totalSpent, 2) }}
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Remaining</h3>
                        <p class="text-2xl font-bold {{ $remaining >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                            ${{ number_format($remaining, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Budget Categories -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="p-6">
                    @forelse($budgets as $type => $typebudgets)
                        <div class="mb-8 last:mb-0">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ ucfirst($type) }}
                            </h3>

                            <!-- Rest of your existing budget cards code remains the same -->
                            @include('budgets.partials.budget-cards', ['typebudgets' => $typebudgets])
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">No budgets set up yet.</p>
                            <a href="{{ route('budgets.create') }}"
                               class="inline-flex items-center px-4 py-2 mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create Your First Budget
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
