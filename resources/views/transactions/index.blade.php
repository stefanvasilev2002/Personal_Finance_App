<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transactions') }}
            </h2>
            <a href="{{ route('transactions.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                New Transaction
            </a>
        </div>
    </x-slot>

    <div class="py-12">
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
                                    <th scope="col" class="py-3 px-6">Date</th>
                                    <th scope="col" class="py-3 px-6">Account</th>
                                    <th scope="col" class="py-3 px-6">Category</th>
                                    <th scope="col" class="py-3 px-6">Description</th>
                                    <th scope="col" class="py-3 px-6">Type</th>
                                    <th scope="col" class="py-3 px-6">Amount</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="py-4 px-6">
                                            {{ $transaction->date->format('Y-m-d') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $transaction->account->name }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $transaction->category->name }}
                                        </td>
                                        <td class="py-4 px-6">
                                            {{ $transaction->description ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $transaction->type === 'income'
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400'
                                                        : 'bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400' }}">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                        </td>
                                        <td class="py-4 px-6 font-medium
                                                {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->account->currency }} {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td class="py-4 px-6">
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
