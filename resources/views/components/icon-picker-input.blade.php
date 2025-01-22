@props(['selected' => 'shopping-cart'])

<div x-data="{
    open: false,
    selectedIcon: '{{ $selected }}',
    icons: [
        'shopping-cart', 'home', 'car', 'utensils', 'plane', 'graduation-cap',
        'hospital', 'bus', 'shopping-bag', 'gift', 'coffee', 'gamepad',
        'wallet', 'chart-line', 'book', 'dumbbell', 'film', 'music',
        'burger', 'pizza-slice', 'shirt', 'glasses', 'ring', 'watch'
    ]
}" class="relative">
    <input type="hidden" name="icon" x-model="selectedIcon">

    <button type="button"
            @click="open = !open"
            class="w-full bg-gray-900/50 border border-gray-700 rounded-md p-3 text-left">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i :class="'fas fa-' + selectedIcon" class="text-xl mr-3"></i>
                <span class="text-gray-300" x-text="selectedIcon"></span>
            </div>
            <i class="fas fa-chevron-down text-gray-500"></i>
        </div>
    </button>

    <!-- Dropdown -->
    <div x-show="open"
         @click.away="open = false"
         x-transition
         class="absolute z-50 w-full mt-2 bg-gray-800 border border-gray-700 rounded-md shadow-lg">
        <div class="grid grid-cols-4 gap-2 p-3 max-h-[240px] overflow-y-auto">
            <template x-for="icon in icons" :key="icon">
                <button type="button"
                        @click="selectedIcon = icon; open = false"
                        class="p-3 rounded-md hover:bg-gray-700/50 flex flex-col items-center gap-2"
                        :class="{ 'bg-gray-700': selectedIcon === icon }">
                    <i :class="'fas fa-' + icon" class="text-xl text-gray-300"></i>
                    <span class="text-xs text-gray-400" x-text="icon"></span>
                </button>
            </template>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('iconPicker', (initialIcon = 'shopping-cart') => ({
                isOpen: false,
                selectedIcon: initialIcon,
                selectedColor: '#4F46E5',
                icons: [
                    'shopping-cart', 'home', 'car', 'utensils', 'plane', 'graduation-cap',
                    'hospital', 'bus', 'shopping-bag', 'gift', 'coffee', 'gamepad',
                    'laptop', 'money-bill', 'credit-card', 'piggy-bank', 'wallet',
                    'chart-line', 'book', 'dumbbell', 'film', 'music', 'phone',
                    'burger', 'pizza-slice', 'ice-cream', 'cookie', 'beer', 'wine-glass',
                    'shirt', 'shoes', 'hat', 'glasses', 'ring', 'watch'
                ],
                selectIcon(icon) {
                    this.selectedIcon = icon;
                    this.isOpen = false;
                },
                init() {
                    this.$watch('$store.categoryForm.color', (value) => {
                        this.selectedColor = value;
                    });
                }
            }));
        });
    </script>
@endpush
