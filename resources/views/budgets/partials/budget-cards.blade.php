{{-- resources/views/budgets/partials/budget-cards.blade.php --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($typebudgets as $budget)
        <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 dark:from-gray-800 dark:to-gray-800/50 border dark:border-gray-700 rounded-lg p-4 {{ !$budget->is_active ? 'opacity-75' : '' }} shadow-md hover:shadow-lg transition-all duration-200">
            <!-- Budget Header -->
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center">
                        <h4 class="font-medium text-blue-900 dark:text-white">
                            {{ $budget->category->name }}
                        </h4>
                        @if(!$budget->is_active)
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                Expired
                            </span>
                        @endif
                    </div>
                    <div class="mt-1 text-sm text-blue-600/80 dark:text-white">
                        {{ ucfirst($budget->period) }}
                        @if($budget->is_active)
                            • <span class="text-emerald-600 dark:text-emerald-400">{{ round($budget->remaining_days, 0, PHP_ROUND_HALF_UP) }} days left</span>
                        @else
                            • <span class="text-gray-500 dark:text-gray-400">Ended {{ $budget->end_date->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-1">
                    <a href="{{ route('budgets.edit', $budget) }}"
                       class="p-1.5 text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300
                              rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
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
                                class="p-1.5 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300
                                       rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
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
                <p class="text-2xl font-bold text-blue-600 dark:text-white">
                    ${{ number_format($budget->amount, 2) }}
                </p>
                @if($budget->is_active)
                    <p class="text-sm text-blue-600/80 dark:text-white">
                        Daily: ${{ number_format($budget->daily_budget, 2) }}
                    </p>
                @endif
            </div>

            <!-- Progress Section -->
            <div class="mt-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-blue-600/90 dark:text-white">
                        Spent: ${{ number_format($budget->spent_amount, 2) }}
                    </span>
                    <span class="{{ $budget->spending_percentage > 90 ? 'text-red-500 dark:text-red-400' : 'text-blue-600/90 dark:text-white' }}">
                        {{ number_format($budget->spending_percentage, 1) }}%
                    </span>
                </div>

                <div class="relative">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                        @php
                            $progressColor = match($budget->status) {
                                'expired' => 'bg-gray-500 dark:bg-gray-400',
                                'over' => 'bg-red-500 dark:bg-red-400',
                                'warning' => 'bg-yellow-500 dark:bg-yellow-400',
                                default => 'bg-emerald-500 dark:bg-emerald-400'
                            };
                            $pulseColor = match($budget->status) {
                                'over' => 'bg-red-500/20 dark:bg-red-400/20',
                                'warning' => 'bg-yellow-500/20 dark:bg-yellow-400/20',
                                default => ''
                            };
                        @endphp
                        <div class="{{ $progressColor }} h-2.5 rounded-full transition-all duration-300"
                             style="width: {{ min($budget->spending_percentage, 100) }}%">
                        </div>
                        @if($budget->spending_percentage > 100 || ($budget->spending_percentage > 75 && $budget->is_active))
                            <div class="absolute inset-0">
                                <div class="{{ $pulseColor }} h-2.5 rounded-full animate-pulse"></div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($budget->is_active)
                    @if($budget->spending_percentage > 100)
                        <div class="flex items-center text-sm text-red-600 dark:text-red-400 font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Over budget by ${{ number_format($budget->spent_amount - $budget->amount, 2) }}</span>
                        </div>
                    @elseif($budget->spending_percentage > 75)
                        <div class="flex items-center text-sm text-yellow-600 dark:text-yellow-400 font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Remaining: ${{ number_format($budget->amount - $budget->spent_amount, 2) }}</span>
                        </div>
                    @else
                        <div class="flex items-center text-sm text-emerald-600 dark:text-emerald-400 font-medium">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>On track - ${{ number_format($budget->amount - $budget->spent_amount, 2) }} left</span>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
