<template>
    <app-layout :title="$t('moodle_courses')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_courses') }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <course-metadata-form
                    :categories="categories.data"
                    :languages="languages.data"
                    :mdl_courses="mdl_courses.data"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import CourseMetadataForm from './Partials/CourseMetadataForm';

export default {
    name: 'Create',

    props: ['categories', 'languages', 'mdl_courses'],

    components: {  AppLayout, CourseMetadataForm },
}
</script>
