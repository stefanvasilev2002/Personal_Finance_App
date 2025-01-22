<x-app-layout>
    <div x-data="{ filter: 'all' }">
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-200 leading-tight">
                    {{ __('Categories') }}
                </h2>
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add Category
                </a>
            </div>
        </x-slot>

        <div class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session('success'))
                    <div class="mb-4 bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Filters -->
                        <div class="mb-6 flex flex-wrap gap-4">
                            <button @click="filter = 'all'"
                                    :class="{ 'bg-blue-500': filter === 'all' }"
                                    class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gray-700 hover:bg-blue-500 transition-colors">
                                All
                            </button>
                            <button @click="filter = 'expense'"
                                    :class="{ 'bg-blue-500': filter === 'expense' }"
                                    class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gray-700 hover:bg-blue-500 transition-colors">
                                Expenses
                            </button>
                            <button @click="filter = 'income'"
                                    :class="{ 'bg-blue-500': filter === 'income' }"
                                    class="px-4 py-2 rounded-full text-sm font-medium text-white bg-gray-700 hover:bg-blue-500 transition-colors">
                                Income
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="border border-gray-700 rounded-lg p-4 bg-gray-800 hover:border-gray-600 transition-colors"
                                     x-show="filter === 'all' || filter === '{{ $category->type }}'">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center mr-4"
                                                 style="background-color: {{ $category->color }}20">
                                                <i class="fas fa-{{ $category->icon }} text-2xl"
                                                   style="color: {{ $category->color }}"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-200">{{ $category->name }}</h4>
                                                <p class="text-sm text-gray-400 flex items-center">
                                                    <i class="fas fa-{{ $category->type === 'income' ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                                                    {{ ucfirst($category->type) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('categories.edit', $category) }}"
                                               class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-full transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-red-400 hover:bg-red-500/10 rounded-full transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
