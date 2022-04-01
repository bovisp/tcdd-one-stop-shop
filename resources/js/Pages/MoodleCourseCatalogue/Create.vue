<template>
    <app-layout :title="$t('moodle_catalogue')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_catalogue') }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <course-catalogue-form
                    :metadata="{}"

                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import CourseCatalogueForm from './Partials/CourseCatalogueForm';

export default {
    name: 'Create',

    props: [],

    components: {  AppLayout, CourseCatalogueForm },
}
</script>
