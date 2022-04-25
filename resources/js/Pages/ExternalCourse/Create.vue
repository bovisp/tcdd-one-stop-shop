<template>
    <app-layout title="Webinar Attendance">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('external_course') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <external-course-form

                />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ExternalCourseForm from '@/Pages/ExternalCourse/Partials/ExternalCourseForm';

    export default {
        name: 'Create',

        props: [],

        components: {
            AppLayout,
            ExternalCourseForm
        },
    }
</script>
