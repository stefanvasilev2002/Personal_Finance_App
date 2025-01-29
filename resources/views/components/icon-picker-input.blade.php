@props(['selected' => 'shopping-cart'])

<div x-data="{
    open: false,
    selectedIcon: '{{ $selected }}',
    search: '',
    icons: [
        'utensils', 'shopping-cart', 'pizza-slice', 'coffee',
        'wallet', 'credit-card', 'piggy-bank', 'money-bill', 'chart-line',
        'home', 'car', 'plane', 'bus', 'train',
        'phone', 'laptop', 'tv', 'gamepad', 'book',
        'gift', 'glasses',
    ]
}"
     x-init="$watch('selectedIcon', value => {
        $dispatch('icon-changed', value);
        $root.querySelector('input[name=icon]').value = value;
    })"
     class="relative">

    <input type="hidden" name="icon" :value="selectedIcon">

    <!-- Trigger Button -->
    <button type="button"
            @click="open = !open"
            class="w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md p-3 text-left">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center mr-3">
                    <i :class="'fas fa-' + selectedIcon" class="text-xl text-gray-700 dark:text-gray-300"></i>
                </div>
                <span class="text-gray-700 dark:text-gray-300" x-text="selectedIcon"></span>
            </div>
            <i class="fas fa-chevron-down text-gray-500 transition-transform" :class="{'rotate-180': open}"></i>
        </div>
    </button>

    <!-- Dropdown -->
    <div x-show="open"
         @click.away="open = false"
         x-transition
         class="fixed inset-0 z-50 overflow-y-auto"
         style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="mt-20 min-h-screen px-4 text-center" @click="open = false">
            <div class="fixed inset-0" aria-hidden="true"></div>
            <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 @click.stop>
                <div class="p-4 border-b border-gray-300 dark:border-gray-700">
                    <input type="text"
                           x-model="search"
                           placeholder="Search icons..."
                           class="w-full px-3 py-2 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md text-gray-700 dark:text-gray-300 placeholder-gray-500">
                </div>
                <div class="max-h-[400px] overflow-y-auto p-4">
                    <div class="grid grid-cols-4 gap-3">
                        <template x-for="icon in icons.filter(i => i.includes(search.toLowerCase()))" :key="icon">
                            <button type="button"
                                    @click="selectedIcon = icon; open = false"
                                    class="p-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 flex flex-col items-center gap-2"
                                    :class="{ 'bg-gray-100 dark:bg-gray-800 ring-2 ring-blue-500': selectedIcon === icon }">
                                <div class="w-10 h-10 rounded-lg bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
                                    <i :class="'fas fa-' + icon" class="text-xl text-gray-700 dark:text-gray-300"></i>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400 truncate w-full text-center" x-text="icon"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
