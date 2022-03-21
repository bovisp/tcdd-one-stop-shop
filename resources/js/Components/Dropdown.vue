<template>
    <div>
        <div class="mt-1 relative">
            <button
                type="button"
                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2
                    text-left cursor-default sm:text-sm
                    focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                aria-haspopup="listbox"
                aria-expanded="true"
                aria-labelledby="listbox-label"
                @click="toggleList"
            >
                <span class="flex items-center">
                    <span class="ml-3 block truncate">{{ title }}</span>
                </span>
                <span class="ml-3 absolute inset-y-0 right-0 text-gray-500 flex items-center pr-2 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </span>
            </button>

            <ul
                v-if="open"
                class="absolute z-50 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1
                    ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                tabindex="-1"
                role="listbox"
                aria-labelledby="listbox-label"
            >
                <li
                    v-for="item in items"
                    class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9
                        hover:text-white hover:bg-gray-700"
                    :id="`listbox-option-${item.id}`"
                    role="option"
                    @click="toggleSelection(item.id)"
                >
                    <div class="flex items-center">
                        <span
                            :class="selected.includes(item.id) ? 'font-bold' : 'font-normal'"
                            class=" ml-3 block truncate"
                        >
                            {{ item.label }}
                        </span>
                    </div>
                    <span
                        v-if="selected.includes(item.id)"
                        class="absolute inset-y-0 right-0 flex items-center pr-4"
                    >
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dropdown',

    props: ['items', 'title', 'initialSelection'],

    data() {
        return {
            selected: this.initialSelection || [],
            open: false
        };
    },

    methods: {
        toggleSelection(itemId) {
            if (this.selected.includes(itemId)) {
                this.selected = this.selected.filter(item => item !== itemId);
            } else {
                this.selected.push(itemId);
            }

            this.$emit('change', this.selected);
        },
        toggleList() {
            this.open = ! this.open;
        }
    },
}
</script>

