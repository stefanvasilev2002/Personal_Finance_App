<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('categories.update', $category) }}" method="POST"
                          x-data="{
                            name: '{{ $category->name }}',
                            type: '{{ $category->type }}',
                            color: '{{ $category->color }}',
                            icon: '{{ $category->icon }}'
                        }"
                          @icon-changed.window="icon = $event.detail">
                        @csrf
                        @method('PUT')

                        <!-- Preview -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview</label>
                            <div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md p-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4"
                                         :style="{ backgroundColor: color + '20' }">
                                        <i class="fas" :class="'fa-' + icon" :style="{ color: color }"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-700 dark:text-gray-200" x-text="name || 'Category Name'"></h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="type"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Name Input -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category Name
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   x-model="name"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                            <div class="mt-1 grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="expense"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md peer-checked:border-blue-500 peer-checked:bg-blue-500/10 cursor-pointer flex items-center gap-2">
                                        <i class="fas fa-shopping-cart text-gray-400 peer-checked:text-blue-500"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Expense</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="income"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md peer-checked:border-green-500 peer-checked:bg-green-500/10 cursor-pointer flex items-center gap-2">
                                        <i class="fas fa-wallet text-gray-400 peer-checked:text-green-500"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Income</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Color Picker -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                            <div class="mt-1 flex items-center gap-3">
                                <input type="color"
                                       name="color"
                                       x-model="color"
                                       class="h-10 w-20 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer">
                                <span class="text-gray-500 dark:text-gray-400 text-sm" x-text="color.toUpperCase()"></span>
                            </div>
                        </div>

                        <!-- Icon Picker -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon</label>
                            <div class="mt-1">
                                <x-icon-picker-input :selected="$category->icon" />
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <x-back-button fallback-route="categories.index" text="Back" />
                            <button type="submit"
                                    class="ml-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
