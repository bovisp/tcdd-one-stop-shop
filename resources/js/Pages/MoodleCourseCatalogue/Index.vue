<template>
    <app-layout :title="$t('moodle_catalogue')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_catalogue') }}
            </h2>
        </template>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w=full mt-6 flex items-center justify-end">
                        <a
                            class="bg-gray-800 text-white py-2 px-3 rounded"
                            href="/course-catalogues/create">
                            {{ $t('add_catalogue') }}
                        </a>
                    </div>
                    <catalogue-filter
                            class="mt-6"
                            :items="catalogues.data"
                            :categories="categories.data"
                            :category_id="category_id"
                            :language="language"
                            :keyword="keyword"
                    />
                    <div class="w-full mt-6">
                        <list :items="catalogues"

                        />
                    </div>
                    <div class="w-full mt-6 flex justify-end">
                        <pagination
                                v-if="pagination.lastPage > 1"
                                :current="pagination.current"
                                :last-page="pagination.lastPage"
                                @change="pageChangeHandle"
                        />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import List from './Partials/List';
import CatalogueFilter from './Partials/CatalogueFilter';
import Pagination from './Partials/Pagination';


export default {
    name: 'Index',

    props: [
        'catalogues','categories'
    ],

    components: {
        AppLayout,
        List,
        CatalogueFilter,
        Pagination
    },

    data() {
        return {
            pagination: {
                current: this.catalogues.meta?.current_page,
                lastPage: this.catalogues.meta?.last_page,
            }
        };
    },

    methods: {
        pageChangeHandle(value) {
            switch (value) {
                case 'next':
                    this.pagination.current += 1;
                    break;
                case 'previous':
                    this.pagination.current -= 1;
                    break;
                default:
                    this.pagination.current = value;
            }

            this.$inertia.visit(`/course-catalogues?page=${this.pagination.current}`);
        }
    }
}
</script>
