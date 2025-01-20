<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Financial Goals') }}
            </h2>
            <a href="{{ route('financial-goals.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                New Goal
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($goals->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($goals as $goal)
                                <div class="border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('financial-goals.show', $goal) }}"
                                               class="font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $goal->name }}
                                            </a>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Due {{ $goal->target_date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($goal->priority === 'high')
                                                bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                            @elseif($goal->priority === 'medium')
                                                bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @else
                                                bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @endif">
                                            {{ ucfirst($goal->priority) }}
                                        </span>
                                    </div>

                                    <div class="mt-4">
                                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                            <span>Progress</span>
                                            <span>${{ number_format($goal->current_amount, 2) }} / ${{ number_format($goal->target_amount, 2) }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                            @php
                                                $percentage = min(($goal->current_amount / $goal->target_amount) * 100, 100);
                                            @endphp
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ number_format($percentage, 1) }}% Complete
                                        </p>
                                    </div>

                                    <div class="mt-4 flex justify-between">
                                        <button onclick="document.getElementById('update-progress-{{ $goal->id }}').classList.toggle('hidden')"
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                            Update Progress
                                        </button>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('financial-goals.edit', $goal) }}"
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('financial-goals.destroy', $goal) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Quick Update Progress Form -->
                                    <div id="update-progress-{{ $goal->id }}" class="hidden mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                                        <form action="{{ route('financial-goals.update-progress', $goal) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex space-x-2">
                                                <div class="relative flex-grow">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                                    </div>
                                                    <input type="number" name="current_amount"
                                                           value="{{ $goal->current_amount }}"
                                                           step="0.01" min="0" required
                                                           class="pl-7 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                </div>
                                                <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 dark:text-gray-400">No financial goals set up yet.</p>
                            <a href="{{ route('financial-goals.create') }}"
                               class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Your First Goal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
