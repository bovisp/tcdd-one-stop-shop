<template>
    <app-layout title="Webinar Attendance">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Webinar attendance
            </h2>
        </template>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w=full mt-6 flex items-center justify-between">
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                <a
                                    href="#"
                                    :class='viewMode === "grid" ? "bg-gray-800 text-white" : "bg-whit text-gray-500"'
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border text-sm font-medium"
                                    @click="viewMode = 'grid'"
                                    title="Graphical view"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </a>

                                <a
                                    href="#"
                                    :class='viewMode === "list" ? "bg-gray-800 text-white" : "bg-white text-gray-500"'
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border
                                        border-gray-300 bg-white text-sm font-medium"
                                    @click="viewMode = 'list'"
                                    title="Tabular view"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                        <div>
                            <a
                                class="bg-gray-800 text-white py-2 px-3 rounded"
                                href="/webinar-attendance/create">
                                New attendance
                            </a>
                        </div>
                    </div>
                    <webinar-attendance-filter
                        class="mt-6"
                        :filters="meta.filters"
                        :fiscal-years="meta.fiscal_years.data"
                        :languages="meta.languages.data"
                        :quarters="meta.quarters.data"
                        @apply="applyFilters"
                    />
                    <template v-if="viewMode === 'grid'">
                        <div class="w-full mt-6 grid grid-cols-1 md:grid-cols-2 gap-2 block">
                            <div class="block items-center justify-center mr-1 h-auto">
                                <apex-chart
                                    height="300"
                                    type="bar"
                                    :options="graphsData.fiscalYear.options"
                                    :series="graphsData.fiscalYear.series"
                                />
                            </div>
                            <div class="ml-1 mt-2 md:mt-0">
                                <apex-chart
                                    height="300"
                                    type="bar"
                                    :options="graphsData.language.options"
                                    :series="graphsData.language.series"
                                />
                            </div>
                        </div>
                        <div class="w-full mt-2">
                            <apex-chart
                                height="300"
                                type="bar"
                                :options="graphsData.topFive.options"
                                :series="graphsData.topFive.series"
                            />
                        </div>
                    </template>
                    <template v-else>
                        <div class="w-full mt-6 grid grid-cols-1 md:grid-cols-2 gap-2 block">
                            <table-per-fiscal-year :items="attendance.by_fiscal_year" />
                            <table-per-fiscal-year-and-quarter :items="attendance.by_fy_and_quarter" />
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import ApexChart from 'vue3-apexcharts';
import AppLayout from '@/Layouts/AppLayout.vue';
import TablePerFiscalYear from '@/Pages/WebinarAttendance/Partials/TablePerFiscalYear.vue';
import TablePerFiscalYearAndQuarter from '@/Pages/WebinarAttendance/Partials/TablePerFiscalYearAndQuarter.vue';
import WebinarAttendanceFilter from '@/Components/WebinarAttendanceFilter.vue';

export default {
    name: 'Dashboard',

    props: ['attendance', 'meta'],

    components: {
        ApexChart,
        AppLayout,
        TablePerFiscalYear,
        TablePerFiscalYearAndQuarter,
        WebinarAttendanceFilter
    },

    data() {
        return {
            graphsData : {
                fiscalYear: {
                    options: {
                        chart: {
                            id: 'fiscalyear-bar'
                        },
                        title: {
                            text: 'By Fiscal Year'
                        },
                        xaxis: {
                            categories: Object.keys(this.attendance.by_fiscal_year)
                        }
                    },
                    series: [{
                        name: 'Webinar Attendance by Fiscal Year',
                        data: Object.values(this.attendance.by_fiscal_year)
                    }]
                },
                language: {
                    options: {
                        chart: {
                            id: 'language-bar'
                        },
                        title: {
                            text: 'By Language'
                        },
                        xaxis: {
                            categories: Object.keys(this.attendance.by_language)
                        }
                    },
                    series: [{
                        name: 'Webinar Attendance by Language',
                        data: Object.values(this.attendance.by_language)
                    }]
                },
                topFive: {
                    options: {
                        chart: {
                            id: 'top-five-bar'
                        },
                        title: {
                            text: 'Top 5 Webinars',
                            align: 'center'
                        },
                        xaxis: {
                            categories: Object.keys(this.attendance.top_five)
                        }
                    },
                    series: [{
                        name: 'Top 5 Webinars',
                        data: Object.values(this.attendance.top_five)
                    }]
                },
            },
            viewMode: 'grid',
        }
    },

    methods: {
        applyFilters(filters) {
            const query = new URLSearchParams(filters);

            this.$inertia.visit(`/webinar-attendance/dashboard?${query}`);
        }
    },
}
</script>
