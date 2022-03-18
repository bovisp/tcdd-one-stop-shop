<template>
    <app-layout :title="$t('moodle_courses')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_courses') }}
            </h2>
        </template>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w=full mt-6 flex items-center justify-end">
                        <a
                            class="bg-gray-800 text-white py-2 px-3 rounded"
                            href="/moodle-courses/create">
                            {{ $t('add_metadata') }}
                        </a>
                    </div>
                    <div class="w-full mt-6">
                        <list :items="courses.data"
                              @details="setFeaturedItem"
                              @delete="setItemToDelete"
                              @edit="edit"
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
        <details-modal
            v-if="featuredItem"
            :item="courses.data.find(course => course.id === featuredItem)"
            @close="featuredItem = null"
        />

        <jet-dialog-modal :show="itemToDelete" @close="closeModal">
            <template #title>
                {{ $t('delete_metadata') }}
            </template>

            <template #content>
                {{ $t('are_you_sure') }}
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    {{ $t('cancel') }}
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteItem">
                    {{ $t('delete') }}
                </jet-button>
            </template>
        </jet-dialog-modal>

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import List from './Partials/List';
import DetailsModal from './Partials/DetailsModal';
import Pagination from './Partials/Pagination';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

export default {
    name: 'Index',

    props: {
        courses: Array,
    },

    components: {
        AppLayout,
        DetailsModal,
        JetButton,
        JetDialogModal,
        JetSecondaryButton,
        List,
        Pagination
    },

    data() {
        return {
            featuredItem: null,
            itemToDelete: null,
            pagination: {
                current: this.courses.meta?.current_page,
                lastPage: this.courses.meta?.last_page,
            }
        };
    },

    methods: {
        setFeaturedItem(id) {
            this.featuredItem = id;
        },

        setItemToDelete(id) {
            this.itemToDelete = id;
        },

        deleteItem() {
            this.$inertia.delete(`/moodle-courses/${this.itemToDelete}`);

            this.itemToDelete = null;
        },

        edit(id) {
            this.$inertia.get(`moodle-courses/${id}/edit`);
        },

        closeModal() {
            this.itemToDelete = null;
        },

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

            this.$inertia.visit(`/moodle-courses?page=${this.pagination.current}`);
        }
    }
}
</script>
