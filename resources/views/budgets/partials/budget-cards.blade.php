<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($typebudgets as $budget)
        <div class="border dark:border-gray-700 rounded-lg p-4 {{ !$budget->is_active ? 'opacity-75' : '' }}">
            <!-- Budget Header -->
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center">
                        <h4 class="font-medium text-gray-900 dark:text-gray-100">
                            {{ $budget->category->name }}
                        </h4>
                        @if(!$budget->is_active)
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                Expired
                            </span>
                        @endif
                    </div>
                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ ucfirst($budget->period) }}
                        @if($budget->is_active)
                            • {{ round($budget->remaining_days, 0, PHP_ROUND_HALF_UP) }} days left
                        @else
                            • Ended {{ $budget->end_date->diffForHumans() }}
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-1">
                    <a href="{{ route('budgets.edit', $budget) }}"
                       class="p-1.5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300
                              rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>

                    <form action="{{ route('budgets.destroy', $budget) }}"
                          method="POST"
                          class="inline-block"
                          onsubmit="return confirm('Are you sure you want to delete this budget?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-1.5 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400
                                       rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Budget Amount -->
            <div class="flex justify-between items-baseline mt-4">
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    ${{ number_format($budget->amount, 2) }}
                </p>
                @if($budget->is_active)
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Daily: ${{ number_format($budget->daily_budget, 2) }}
                    </p>
                @endif
            </div>

            <!-- Progress Section -->
            <div class="mt-4 space-y-3">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span>Spent: ${{ number_format($budget->spent_amount, 2) }}</span>
                    <span>{{ number_format($budget->spending_percentage, 1) }}%</span>
                </div>

                <div class="relative">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        @php
                            $progressColor = match($budget->status) {
                                'expired' => 'bg-gray-600 dark:bg-gray-500',
                                'over' => 'bg-red-600 dark:bg-red-500',
                                'warning' => 'bg-yellow-600 dark:bg-yellow-500',
                                default => 'bg-blue-600 dark:bg-blue-500'
                            };
                        @endphp
                        <div class="{{ $progressColor }} h-2 rounded-full transition-all duration-300"
                             style="width: {{ $budget->spending_percentage }}%">
                        </div>
                    </div>
                </div>

                @if($budget->is_active)
                    @if($budget->spending_percentage > 100)
                        <div class="flex items-center text-sm text-red-600 dark:text-red-400">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Over budget!</span>
                        </div>
                    @elseif($budget->spending_percentage > 75)
                        <div class="flex items-center text-sm text-yellow-600 dark:text-yellow-400">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Approaching limit</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
