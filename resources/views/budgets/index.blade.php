<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Budgets') }}
            </h2>
            <a href="{{ route('budgets.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                New Budget
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($budgets as $type => $typebudgets)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ ucfirst($type) }} Budgets
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($typebudgets as $budget)
                                    <div class="border dark:border-gray-700 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $budget->category->name }}
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ ucfirst($budget->period) }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('budgets.edit', $budget) }}"
                                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('budgets.destroy', $budget) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <p class="text-2xl font-bold mt-2 text-gray-900 dark:text-gray-100">
                                            ${{ number_format($budget->amount, 2) }}
                                        </p>
                                        <div class="mt-2">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                @php
                                                    $spending = $budget->category
                                                        ->transactions()
                                                        ->where('type', 'expense')
                                                        ->whereBetween('date', [
                                                            $budget->start_date,
                                                            $budget->end_date ?? now()
                                                        ])
                                                        ->sum('amount');
                                                    $percentage = min(($spending / $budget->amount) * 100, 100);
                                                @endphp
                                                <div class="bg-blue-600 h-2.5 rounded-full"
                                                     style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                ${{ number_format($spending, 2) }} spent
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">No budgets set up yet.</p>
                            <a href="{{ route('budgets.create') }}"
                               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Your First Budget
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
