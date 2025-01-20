<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transaction Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('transactions.edit', $transaction) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Transaction
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Transaction Details -->
                    <dl class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Type and Amount -->
                        <div class="col-span-2 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</dt>
                            <dd class="mt-1 text-3xl font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                {{ $transaction->account->currency }} {{ number_format($transaction->amount, 2) }}
                            </dd>
                        </div>

                        <!-- Account -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Account</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                {{ $transaction->account->name }}
                            </dd>
                        </div>

                        <!-- Category -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                {{ $transaction->category->name }}
                            </dd>
                        </div>

                        <!-- Description -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                {{ $transaction->description ?: 'No description provided' }}
                            </dd>
                        </div>

                        <!-- Date -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                {{ $transaction->date->format('F j, Y') }}
                            </dd>
                        </div>

                        <!-- Recurring Status -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Recurring Status</dt>
                            <dd class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                @if($transaction->is_recurring)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Recurring
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                                        One-time
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <!-- Created/Updated Info -->
                        <div class="col-span-2 mt-4 border-t border-gray-200 dark:border-gray-600 pt-4">
                            <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                                <p>Created: {{ $transaction->created_at->format('M d, Y H:i') }}</p>
                                <p>Last Updated: {{ $transaction->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </dl>

                    <!-- Actions -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Transaction
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
