<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Accounts') }}
            </h2>
            <a href="{{ route('accounts.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                New Account
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($accountsData as $data)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ $data['account']->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ ucfirst($data['account']->type) }}
                                    </p>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.edit', $data['account']) }}"
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                    <form action="{{ route('accounts.destroy', $data['account']) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure? This will also delete all associated transactions.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 mb-2">
                                <span class="h-2 w-2 rounded-full {{ $data['monthlyActivity']['isActive'] ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $data['monthlyActivity']['isActive'] ? 'Active this month' : 'Inactive this month' }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <p class="text-2xl font-bold {{ $data['account']->balance >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $data['account']->currency }} {{ number_format($data['account']->balance, 2) }}
                                </p>
                            </div>

                            <div class="mt-4 flex space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <span>Income:</span>
                                    <span class="text-green-400">+${{ number_format($data['stats']['monthlyIncome'], 2) }}</span>
                                </div>
                                <div>
                                    <span>Expenses:</span>
                                    <span class="text-red-400">-${{ number_format($data['stats']['monthlyExpenses'], 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('accounts.show', $data['account']) }}"
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                                    View Transactions →
                                </a>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="{{ route('transactions.create', ['account' => $data['account']->id]) }}"
                                   class="text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded">
                                    Add Transaction
                                </a>
                                <button onclick="document.getElementById('transfer-form-{{ $data['account']->id }}').classList.toggle('hidden')"
                                        class="text-center border border-gray-600 hover:bg-gray-700 text-gray-200 text-sm font-medium py-2 px-4 rounded">
                                    Transfer
                                </button>
                            </div>

                            <!-- Quick Transfer Form -->
                            @include('accounts.partials.transfer-form', ['account' => $data['account']])

                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-400">Last Transaction</p>
                                        @if($data['lastTransaction'])
                                            <p class="text-gray-200">{{ $data['lastTransaction']->date->format('M d, Y') }}</p>
                                        @else
                                            <p class="text-gray-500">No transactions</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-400">Monthly Change</p>
                                        <p class="text-{{ $data['monthlyChange']['percentageChange'] >= 0 ? 'green' : 'red' }}-400">
                                            {{ $data['monthlyChange']['percentageChange'] >= 0 ? '+' : '' }}{{ number_format($data['monthlyChange']['percentageChange'], 1) }}%
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-center">
                                <p class="text-gray-600 dark:text-gray-400">No accounts found.</p>
                                <a href="{{ route('accounts.create') }}"
                                   class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create Your First Account
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
