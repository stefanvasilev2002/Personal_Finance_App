<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf

                        <!-- Account Selection -->
                        <div class="mb-4">
                            <label for="account_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account
                            </label>
                            <select name="account_id" id="account_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Account</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id || request('account') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }} ({{ $account->currency }})
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Transaction Type
                            </label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Type</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                            </label>
                            <select name="category_id" id="category_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                @foreach($categories->groupBy('type') as $type => $typeCategories)
                                    <optgroup label="{{ ucfirst($type) }}" data-type="{{ $type }}">
                                        @foreach($typeCategories as $category)
                                            <option value="{{ $category->id }}" data-type="{{ $type }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('category_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Amount
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" required
                                       step="0.01" min="0.01"
                                       value="{{ old('amount') }}"
                                       class="pl-7 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            @error('amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <input type="text" name="description" id="description"
                                   value="{{ old('description') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Date
                            </label>
                            <input type="date" name="date" id="date" required
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Recurring -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_recurring" value="1"
                                       {{ old('is_recurring') ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">This is a recurring transaction</span>
                            </label>
                            @error('is_recurring')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <x-back-button fallback-route="transactions.index" text="Back" />

                            <button type="submit"
                                    class="font-bold ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const categorySelect = document.getElementById('category_id');

            function filterCategories(selectedType) {
                const options = categorySelect.getElementsByTagName('option');
                for (let option of options) {
                    if (option.value === '') continue;

                    const optionType = option.getAttribute('data-type');
                    if (!selectedType || selectedType === optionType) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                }

                const currentOption = categorySelect.options[categorySelect.selectedIndex];
                if (currentOption && currentOption.value !== '' && currentOption.getAttribute('data-type') !== selectedType) {
                    categorySelect.value = '';
                }
            }

            typeSelect.addEventListener('change', function() {
                filterCategories(this.value);
            });

            categorySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.value !== '') {
                    const categoryType = selectedOption.getAttribute('data-type');
                    typeSelect.value = categoryType;
                    filterCategories(categoryType);
                }
            });

            if (typeSelect.value) {
                filterCategories(typeSelect.value);
            }
        });
    </script>
</x-app-layout>
