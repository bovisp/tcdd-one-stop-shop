<template>
    <app-layout :title="$t('moodle_views_completions')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('moodle_views_completions') }}
            </h2>
        </template>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w=full mt-6 flex items-center justify-between">
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px mr-4">
                                <a
                                    href="#"
                                    :class='viewMode === "grid" ? "bg-gray-800 text-white" : "bg-whit text-gray-500"'
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border text-sm font-medium"
                                    @click="viewMode = 'grid'"
                                    :title="$t('graphical_view')"
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
                                    :title="$t('tabular_view')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                </a>
                            </nav>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                <a
                                    href="#"
                                    :class='subject === "views" ? "bg-gray-800 text-white" : "bg-whit text-gray-500"'
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border text-sm font-medium"
                                    @click="subject = 'views'"
                                    :title="$t('graphical_view')"
                                >
                                    {{ $t('views') }}
                                </a>

                                <a
                                    href="#"
                                    :class='subject === "completions" ? "bg-gray-800 text-white" : "bg-white text-gray-500"'
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border
                                        border-gray-300 bg-white text-sm font-medium"
                                    @click="subject = 'completions'"
                                    :title="$t('tabular_view')"
                                >
                                    {{ $t('completions') }}
                                </a>
                            </nav>
                        </div>
                    </div>
                    <views-filter
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
                                    :options="graphsData[subject].fiscalYear.options"
                                    :series="graphsData[subject].fiscalYear.series"
                                />
                            </div>
                            <div class="ml-1 mt-2 md:mt-0">
                                <apex-chart
                                    height="300"
                                    type="bar"
                                    :options="graphsData[subject].language.options"
                                    :series="graphsData[subject].language.series"
                                />
                            </div>
                        </div>
                        <div class="w-full mt-2">
                            <apex-chart
                                height="300"
                                type="bar"
                                :options="graphsData[subject].topFive.options"
                                :series="graphsData[subject].topFive.series"
                            />
                        </div>
                    </template>
                    <template v-else>
                        <div class="w-full mt-6 grid grid-cols-1 md:grid-cols-2 gap-2 block">
                            <table-per-fiscal-year v-if="subject === 'views'" :items="views.by_fiscal_year" />
                            <table-per-fiscal-year v-if="subject === 'completions'" :items="completions.by_fiscal_year" />
                            <table-per-fiscal-year-and-quarter v-if="subject === 'views'" :items="views.by_fy_and_quarter" />
                            <table-per-fiscal-year-and-quarter v-if="subject === 'completions'" :items="completions.by_fy_and_quarter" />
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
import TablePerFiscalYear from '@/Pages/MoodleViewsCompletions/Partials/TablePerFiscalYear.vue';
import TablePerFiscalYearAndQuarter from '@/Pages/MoodleViewsCompletions/Partials/TablePerFiscalYearAndQuarter.vue';
import ViewsFilter from '@/Pages/MoodleViewsCompletions/Partials/Filter.vue';

export default {
    name: 'Dashboard',

    props: ['views', 'completions', 'meta'],

    components: {
        ApexChart,
        AppLayout,
        TablePerFiscalYear,
        TablePerFiscalYearAndQuarter,
        ViewsFilter
    },

    data() {
        return {
            graphsData : {
                views: {
                    fiscalYear: {
                        options: {
                            chart: {
                                id: 'fiscalyear-bar'
                            },
                            title: {
                                text: this.$i18n.t('by_fiscal_year')
                            },
                            xaxis: {
                                categories: Object.keys(this.views.by_fiscal_year)
                            }
                        },
                        series: [{
                            name: 'Moodle views by Fiscal Year',
                            data: Object.values(this.views.by_fiscal_year)
                        }]
                    },
                    language: {
                        options: {
                            chart: {
                                id: 'language-bar'
                            },
                            title: {
                                text: this.$i18n.t('by_language')
                            },
                            xaxis: {
                                categories: Object.keys(this.views.by_language)
                            }
                        },
                        series: [{
                            name: 'Moodle views by Language',
                            data: Object.values(this.views.by_language)
                        }]
                    },
                    topFive: {
                        options: {
                            chart: {
                                id: 'top-five-bar'
                            },
                            title: {
                                text: 'Top 5 Courses',
                                align: 'center'
                            },
                            xaxis: {
                                categories: Object.keys(this.views.top_five)
                            }
                        },
                        series: [{
                            name: 'Top 5 Courses',
                            data: Object.values(this.views.top_five)
                        }]
                    },
                },
                completions: {
                    fiscalYear: {
                        options: {
                            chart: {
                                id: 'fiscalyear-bar'
                            },
                            title: {
                                text: this.$i18n.t('by_fiscal_year')
                            },
                            xaxis: {
                                categories: Object.keys(this.completions.by_fiscal_year)
                            }
                        },
                        series: [{
                            name: 'Moodle completions by Fiscal Year',
                            data: Object.values(this.completions.by_fiscal_year)
                        }]
                    },
                    language: {
                        options: {
                            chart: {
                                id: 'language-bar'
                            },
                            title: {
                                text: this.$i18n.t('by_language')
                            },
                            xaxis: {
                                categories: Object.keys(this.completions.by_language)
                            }
                        },
                        series: [{
                            name: 'Moodle completions by Language',
                            data: Object.values(this.completions.by_language)
                        }]
                    },
                    topFive: {
                        options: {
                            chart: {
                                id: 'top-five-bar'
                            },
                            title: {
                                text: 'Top 5 Courses',
                                align: 'center'
                            },
                            xaxis: {
                                categories: Object.keys(this.completions.top_five)
                            }
                        },
                        series: [{
                            name: 'Top 5 Courses',
                            data: Object.values(this.completions.top_five)
                        }]
                    },
                },
            },
            viewMode: 'grid',
            subject: 'views'
        }
    },

    methods: {
        applyFilters(filters) {
            filters.subject = this.subject;

            const query = new URLSearchParams(filters);

            this.$inertia.visit(`/moodle-views-completions/dashboard?${query}`);
        }
    },
}
</script>
