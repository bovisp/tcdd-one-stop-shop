<template>
    <div class="flex w-full items-end">
        <div class="flex-1">
            <jet-label for="fiscal-year--filter" :value="$t('fiscal_year')" />
            <Dropdown
                :items="fiscalYears.map(year => ({ label: year.label, id: year.label }))"
                :initial-selection="selected.fiscalYears"
                :title="$t('fiscal_year')"
                @change="setFiscalYears"
            />
        </div>
        <div class="ml-4 flex-1 items-end">
            <jet-label for="quarter--filter" :value="$t('quarter')" />
            <Dropdown
                :items="quarters.map(year => ({ label: year.label, id: year.label }))"
                :initial-selection="selected.quarters"
                :title="$t('quarter')"
                @change="setQuarters"
            />
        </div>
        <div class="ml-4 flex-1">
            <jet-label for="language--filter" :value="$t('language')" />
            <Dropdown
                :items="languages"
                :initial-selection="selected.languages"
                :title="$t('language')"
                @change="setLanguages"
            />
        </div>
        <div class="ml-4 flex items-end">
            <button
                :title="$t('reload')"
                class="h-10 bg-gray-200 px-2 py-3 flex items-center rounded"
                @click="apply"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import Dropdown from '@/Components/Dropdown';
import JetLabel from '@/Jetstream/Label.vue';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

export default {
    name: 'Filter',

    props: ['filters', 'fiscalYears', 'languages', 'quarters'],

    components: {
        JetLabel,
        Dropdown,
        vSelect
    },

    data() {
        return {
            selected: {
                fiscalYears: this.filters.fiscal_years,
                quarters: this.filters.quarters,
                languages: this.filters.languages
            },
        };
    },

    methods: {
        apply() {
            this.$emit('apply', {
                fiscalYear: this.selected.fiscalYears.join(','),
                quarter: this.selected.quarters.join(','),
                language: this.selected.languages.join(',')
            });
        },

        setFiscalYears(years) {
            this.selected.fiscalYears = years;
        },

        setQuarters(quarters) {
            this.selected.quarters = quarters;
        },

        setLanguages(languages) {
            this.selected.languages = languages;
        }
    }
}
</script>
