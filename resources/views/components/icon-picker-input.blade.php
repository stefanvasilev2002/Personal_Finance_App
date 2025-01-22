@props(['selected' => 'shopping-cart'])

<div x-data="{
    open: false,
    selectedIcon: '{{ $selected }}',
    search: '',
    icons: [
        'utensils', 'shopping-cart', 'pizza-slice', 'burger', 'coffee',
        'wallet', 'credit-card', 'piggy-bank', 'money-bill', 'chart-line',
        'home', 'car', 'plane', 'bus', 'train'
    ]
}"
     x-init="$watch('selectedIcon', value => {
        $dispatch('icon-changed', value);
        $root.querySelector('input[name=icon]').value = value;
    })"
     class="relative">

    <input type="hidden" name="icon" :value="selectedIcon">

    <button type="button"
            @click="open = !open"
            class="w-full bg-[#12151e] border border-[#2a3142] rounded-lg p-3 text-left">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-lg bg-[#1a1f2b] flex items-center justify-center mr-3">
                    <i :class="'fas fa-' + selectedIcon" class="text-xl text-gray-200"></i>
                </div>
                <span class="text-gray-200" x-text="selectedIcon"></span>
            </div>
            <i class="fas fa-chevron-down text-gray-400 transition-transform" :class="{'rotate-180': open}"></i>
        </div>
    </button>

    <div x-show="open"
         @click.away="open = false"
         x-transition
         class="absolute z-50 w-full mt-2 bg-[#1a1f2b] border border-[#2a3142] rounded-lg shadow-xl">
        <div class="p-2 border-b border-[#2a3142]">
            <input type="text"
                   x-model="search"
                   placeholder="Search icons..."
                   class="w-full px-3 py-2 bg-[#12151e] border border-[#2a3142] rounded-lg text-gray-200 placeholder-gray-500">
        </div>
        <div class="max-h-[200px] overflow-y-auto">
            <div class="grid grid-cols-4 gap-1.5 p-2">
                <template x-for="icon in icons.filter(i => i.includes(search.toLowerCase()))" :key="icon">
                    <button type="button"
                            @click="selectedIcon = icon; open = false"
                            class="p-2 rounded-lg hover:bg-[#12151e] flex flex-col items-center gap-1.5"
                            :class="{ 'bg-[#12151e] ring-1 ring-blue-500': selectedIcon === icon }">
                        <div class="w-7 h-7 rounded-lg bg-[#1a1f2b] flex items-center justify-center">
                            <i :class="'fas fa-' + icon" class="text-lg text-gray-200"></i>
                        </div>
                        <span class="text-xs text-gray-400 truncate w-full text-center" x-text="icon"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>
