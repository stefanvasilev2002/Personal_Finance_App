<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800/50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('categories.store') }}" method="POST" x-data="{
                        name: '',
                        type: 'expense',
                        color: '#4F46E5'
                    }">
                        @csrf

                        <!-- Preview -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Preview</label>
                            <div class="bg-gray-900/50 border border-gray-700 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3"
                                         :style="{ backgroundColor: color + '20' }">
                                        <i class="fas"
                                           :class="'fa-' + $refs.iconPicker.querySelector('input').value"
                                           :style="{ color: color }">
                                        </i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-200" x-text="name || 'Category Name'"></h4>
                                        <p class="text-sm text-gray-400" x-text="type"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name Input -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-400 mb-2">
                                Category Name
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   x-model="name"
                                   class="w-full bg-gray-900/50 border border-gray-700 rounded-md py-2 px-3 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Type</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="expense"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 border border-gray-700 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-500/10 cursor-pointer flex items-center">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        <span>Expense</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="income"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 border border-gray-700 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-500/10 cursor-pointer flex items-center">
                                        <i class="fas fa-wallet mr-2"></i>
                                        <span>Income</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Color Picker -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Color</label>
                            <input type="color"
                                   name="color"
                                   x-model="color"
                                   class="h-10 w-20 bg-gray-900/50 border border-gray-700 rounded cursor-pointer">
                        </div>

                        <!-- Icon Picker -->
                        <div class="mb-6" x-ref="iconPicker">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Icon</label>
                            <x-icon-picker-input :selected="old('icon', 'shopping-cart')" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                    onclick="window.location='{{ route('categories.index') }}'"
                                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-gray-200 rounded-md">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-md">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
