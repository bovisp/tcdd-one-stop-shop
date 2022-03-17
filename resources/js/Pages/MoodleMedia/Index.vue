<template>
    <app-layout :title="$t('moodle_media')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_media') }}
            </h2>
        </template>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w=full mt-6 flex items-center justify-end">
                        <a
                            class="bg-gray-800 text-white py-2 px-3 rounded"
                            href="/moodle-media/create">
                            {{ $t('moodle_media') }}
                        </a>
                    </div>
                    <div class="w-full mt-6">
                        <list :items="media.data" @details="setFeaturedItem" @delete="setItemToDelete"/>
                    </div>
                    <!--TODO: implement pagination-->
                    <!--<div class="w-full mt-6 flex justify-end">-->
                    <!--<pagination />-->
                    <!--</div>-->
                </div>
            </div>
        </div>
        <details-modal
            v-if="featuredItem"
            :item="media.data.find(media => media.id === featuredItem)"
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

    props: ['meta', 'media'],

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
            itemToDelete: null
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
            console.log('delete item: ' + this.itemToDelete);

            this.$inertia.delete(`/moodle-media/${this.itemToDelete}`);

            this.itemToDelete = null;
        },

        closeModal() {
            this.itemToDelete = null;
        }
    }
}
</script>
