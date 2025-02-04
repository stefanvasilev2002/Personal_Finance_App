<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Expense Budgets') }}
            </h2>
            <a href="{{ route('budgets.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                New Budget
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-4 rounded-lg bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400 border border-green-400/30 shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-lg bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400 border border-red-400/30 shadow-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Budget Card -->
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 dark:from-blue-600/20 dark:to-blue-700/20 shadow-lg rounded-lg border border-blue-100 dark:border-blue-800/50 backdrop-blur-sm">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Budget</h3>
                        </div>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            ${{ number_format($totalBudget, 2) }}
                        </p>
                    </div>
                </div>

                <!-- Total Expenses Card -->
                <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 dark:from-purple-600/20 dark:to-purple-700/20 shadow-lg rounded-lg border border-purple-100 dark:border-purple-800/50 backdrop-blur-sm">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expenses</h3>
                        </div>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            ${{ number_format($totalSpent, 2) }}
                        </p>
                    </div>
                </div>

                <!-- Remaining Card -->
                <div class="bg-gradient-to-br {{ $remaining >= 0 ? 'from-emerald-500/10 to-emerald-600/10 dark:from-emerald-600/20 dark:to-emerald-700/20 border-emerald-100 dark:border-emerald-800/50' : 'from-red-500/10 to-red-600/10 dark:from-red-600/20 dark:to-red-700/20 border-red-100 dark:border-red-800/50' }} shadow-lg rounded-lg border backdrop-blur-sm">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 {{ $remaining >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Remaining</h3>
                        </div>
                        <p class="text-2xl font-bold {{ $remaining >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                            ${{ number_format($remaining, 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Budget Categories -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    @forelse($budgets as $type => $typebudgets)
                        <div class="mb-8 last:mb-0">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($type) }}
                                </h3>
                            </div>

                            @include('budgets.partials.budget-cards', ['typebudgets' => $typebudgets])
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">No budgets set up yet.</p>
                            <a href="{{ route('budgets.create') }}"
                               class="inline-flex items-center px-4 py-2 mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
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
