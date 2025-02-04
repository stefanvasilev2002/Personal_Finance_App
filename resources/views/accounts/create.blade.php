<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account Name
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name') }}"
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
                                <option value="">Select Type</option>
                                <option value="checking" {{ old('type') == 'checking' ? 'selected' : '' }}>Checking</option>
                                <option value="savings" {{ old('type') == 'savings' ? 'selected' : '' }}>Savings</option>
                                <option value="credit" {{ old('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="balance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Initial Balance
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="balance" id="balance" step="0.01" min="0" required
                                       value="{{ old('balance') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            @error('balance')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Currency
                            </label>
                            <select name="currency" id="currency" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Currency</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                                <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                            </select>
                            @error('currency')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <x-back-button fallback-route="accounts.index" text="Back" />
                            <button type="submit"
                                    class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
