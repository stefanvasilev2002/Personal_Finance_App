<x-app-layout>
    <div class="min-h-screen bg-gray-900 pb-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#1a1f2b] rounded-xl shadow-lg">
                <div class="p-6">
                    <form action="{{ route('categories.store') }}" method="POST" x-data="{
                        name: '',
                        type: 'expense',
                        color: '#FF5722',
                        icon: 'shopping-cart'
                    }"
                          @icon-changed.window="icon = $event.detail"
                    >

                        @csrf

                        <!-- Preview -->
                        <div class="mb-8 bg-[#12151e] rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-300 mb-3">Preview</label>
                            <div class="bg-[#1a1f2b] border border-[#2a3142] rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4"
                                         :style="{ backgroundColor: color + '20' }">
                                        <i class="fas" :class="'fa-' + icon" :style="{ color: color }"></i>
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
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                Category Name
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   x-model="name"
                                   class="w-full bg-[#12151e] border border-[#2a3142] rounded-lg py-2.5 px-4 text-black placeholder-gray-500 focus:outline-none focus:border-blue-500"
                                   required>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Type</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="expense"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 bg-[#12151e] border border-[#2a3142] rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-500/10 cursor-pointer flex items-center gap-2">
                                        <i class="fas fa-shopping-cart text-gray-400 peer-checked:text-blue-400"></i>
                                        <span class="text-gray-300">Expense</span>
                                    </div>
                                </label>
                                <label class="relative">
                                    <input type="radio"
                                           name="type"
                                           value="income"
                                           x-model="type"
                                           class="peer sr-only">
                                    <div class="p-3 bg-[#12151e] border border-[#2a3142] rounded-lg peer-checked:border-green-500 peer-checked:bg-green-500/10 cursor-pointer flex items-center gap-2">
                                        <i class="fas fa-wallet text-gray-400 peer-checked:text-green-400"></i>
                                        <span class="text-gray-300">Income</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Color Picker -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color"
                                       name="color"
                                       x-model="color"
                                       class="h-10 w-20 bg-[#12151e] border border-[#2a3142] rounded-lg cursor-pointer">
                                <span class="text-gray-400 text-sm" x-text="color.toUpperCase()"></span>
                            </div>
                        </div>

                        <!-- Icon Picker -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Icon</label>
                            <x-icon-picker-input :selected="'shopping-cart'" @icon-selected="updateIcon($event.detail)" />
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="button"
                                    onclick="window.history.back()"
                                    class="px-4 py-2 bg-[#2a3142] hover:bg-[#343d4f] text-gray-200 rounded-lg">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
