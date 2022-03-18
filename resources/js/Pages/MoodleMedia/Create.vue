<template>
    <app-layout :title="$t('moodle_media')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_media') }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <moodle-media-metadata-form
                    :licenses="licenses.data"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import MoodleMediaMetadataForm from './Partials/MoodleMediaMetadataForm';

export default {
    name: 'Create',

    props: ['licenses'],

    components: {  AppLayout, MoodleMediaMetadataForm },
}
</script>
