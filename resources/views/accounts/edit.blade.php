<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('accounts.update', $account) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account Name
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $account->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account Type
                            </label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="checking" {{ old('type', $account->type) == 'checking' ? 'selected' : '' }}>Checking</option>
                                <option value="savings" {{ old('type', $account->type) == 'savings' ? 'selected' : '' }}>Savings</option>
                                <option value="credit" {{ old('type', $account->type) == 'credit' ? 'selected' : '' }}>Credit</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Currency
                            </label>
                            <select name="currency" id="currency" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="USD" {{ old('currency', $account->currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency', $account->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency', $account->currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="JPY" {{ old('currency', $account->currency) == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                                <option value="CAD" {{ old('currency', $account->currency) == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                            </select>
                            @error('currency')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Account
                            </button>

                            <a href="{{ route('accounts.index') }}"
                               class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this account?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
