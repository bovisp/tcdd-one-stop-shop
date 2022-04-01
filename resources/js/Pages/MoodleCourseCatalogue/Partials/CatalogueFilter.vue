<template>
    <div class="flex w-full items-end">
        <form class="flex w-full items-end" @submit.prevent="submit">

        <div class="ml-4 flex-1 ">
            <jet-label for="keyword--filter" :value="$t('keyword')" />
            <input
                    id="keywordr"
                    type="text"
                    v-model="form.keyword"
             />
        </div>
        <div class="ml-4 flex-1 items-end">
            <jet-label for="category" :value="$t('category')" />

            <v-select
                    id="category"
                    v-model="form.category_id"
                    :options="categories"
                    :reduce="category => category.id"
            />
        </div>
        <div class="ml-4 flex-1">
            <jet-label for="language" :value="$t('language')" />
            <select
                    id="language"
                    class="mt-1 w-full border-gray-300 focus:border-indigo-300
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    v-model="form.language"
            >
                <option value="0"></option>
                <option :value="English">
                        English
                </option>
                <option :value="French">
                        French
                </option>
            </select>
        </div>
        <div class="ml-4 flex items-end">
            <button
                    :title="$t('reload')"
                    class="h-10 bg-gray-200 px-2 py-3 flex items-center rounded"
                    @click="submit"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
            <div class="ml-4 flex items-end">
                <a href="#" @click="back">Reset</a>
            </div>
        </form>
    </div>
</template>

<script>
    import JetLabel from '@/Jetstream/Label.vue';
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';


    export default {

        name: "CatalogueFilter",
        props: ['categories','items'],

        components:{
            JetLabel,
            vSelect
        },
        data() {
            return {
                form: {
                    language:'',
                    category_id:'',
                    keyword:'',
                },
            }
        },

        methods: {
            submit() {
                this.$inertia.get(`/course-catalogues/`,this.form);
            },
            back() {
                this.$inertia.visit('/course-catalogues');
            },
        }
    }
</script>