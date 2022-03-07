<template>
    <app-layout title="Webinar Attendance">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Webinar attendance
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <attendance-form
                    :fiscal-years="fiscal_years.data"
                    :languages="languages.data"
                    :quarters="quarters.data"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import AttendanceForm from '@/Pages/WebinarAttendance/Partials/AttendanceForm';

export default {
    name: 'Create',

    props: ['fiscal_years', 'languages', 'quarters'],

    components: {
        AppLayout,
        AttendanceForm
    },
}
</script>
