<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $financialGoal->name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('financial-goals.edit', $financialGoal) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Goal
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Goal Progress -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Progress Tracking</h3>
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                <span class="text-gray-900 dark:text-gray-100">
                                    ${{ number_format($financialGoal->current_amount, 2) }} / ${{ number_format($financialGoal->target_amount, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-4 mb-4">
                                @php
                                    $percentage = min(($financialGoal->current_amount / $financialGoal->target_amount) * 100, 100);
                                @endphp
                                <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ number_format($percentage, 1) }}% Complete
                            </p>
                        </div>
                    </div>

                    <!-- Goal Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Goal Details</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Target Date</dt>
                                    <dd class="text-gray-900 dark:text-gray-100">{{ $financialGoal->target_date->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Priority</dt>
                                    <dd>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($financialGoal->priority === 'high')
                                                bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                            @elseif($financialGoal->priority === 'medium')
                                                bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @else
                                                bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @endif">
                                            {{ ucfirst($financialGoal->priority) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Time Remaining</dt>
                                    <dd class="text-gray-900 dark:text-gray-100">
                                        {{ now()->diffForHumans($financialGoal->target_date, ['parts' => 2]) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Description</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $financialGoal->description ?: 'No description provided.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Update Progress Form -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Update Progress</h3>
                        <form action="{{ route('financial-goals.update-progress', $financialGoal) }}" method="POST" class="max-w-md">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="current_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Current Amount
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="current_amount" id="current_amount"
                                           value="{{ $financialGoal->current_amount }}"
                                           step="0.01" min="0" required
                                           class="pl-7 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Update Progress
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
