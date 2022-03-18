<template>
    <div class="hidden sm:flex sm:items-center sm:justify-between">
        <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <a
                    href="#"
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white
                        text-sm font-medium text-gray-500 hover:bg-gray-50"
                    @click="goToPage('previous')"
                >
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                <a
                    v-for="option in options"
                    @click="goToPage(option)"
                    href="#"
                    class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center
                        px-4 py-2 border text-sm font-medium bg-white border-gray-300 text-gray-500 hover:bg-gray-50"
                    :class="{ 'z-10 bg-indigo-50 border-indigo-400 text-indigo-500': option === current }"
                    > {{ option }} </a>
                <a
                    href="#"
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300
                        bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    @click="goToPage('next')"
                >
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Pagination',

    props: {
        current: {
            type: Number,
            required: true
        },
        lastPage: {
            type: Number,
            required: true
        },
    },

    computed: {
        shouldDisablePrevious() {
            return this.current === 1;
        },

        shouldDisableNext() {
            return this.current === this.lastPage;
        },

        options() {
            const currentPage = this.current;
            const pageCount = this.lastPage;
            const visiblePagesCount = pageCount || 5;
            const visiblePagesThreshold = (visiblePagesCount - 1) / 2;
            const pagintationTriggersArray = Array(visiblePagesCount - 1).fill(0);

            if (currentPage <= visiblePagesThreshold + 1) {
                pagintationTriggersArray[0] = 1;
                const pagintationTriggers = pagintationTriggersArray.map(
                    (paginationTrigger, index) => {
                        return pagintationTriggersArray[0] + index;
                    }
                )
                pagintationTriggers.push(pageCount);
                return pagintationTriggers;
            }

            if (currentPage >= pageCount - visiblePagesThreshold + 1) {
                const pagintationTriggers = pagintationTriggersArray.map(
                    (paginationTrigger, index) => {
                        return pageCount - index;
                    }
                )
                pagintationTriggers.reverse().unshift(1);
                return pagintationTriggers;
            }

            pagintationTriggersArray[0] = currentPage - visiblePagesThreshold + 1
            const pagintationTriggers = pagintationTriggersArray.map(
                (paginationTrigger, index) => {
                    return pagintationTriggersArray[0] + index;
                }
            )
            pagintationTriggers.unshift(1);
            pagintationTriggers[pagintationTriggers.length - 1] = pageCount;
            return pagintationTriggers;
        }
    },

    methods: {
        goToPage(value) {
            if (this.shouldDisablePrevious && value === 'previous') {
                return;
            }

            if (this.shouldDisableNext && value === 'next') {
                return;
            }

            this.$emit('change', value);
        }
    }
}
</script>
