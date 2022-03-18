<template>
    <jet-form-section  @submitted="submit">
        <template #title>
            {{ $t('add_metadata') }}
        </template>

        <template #form>
            <div class="col-span-12">
                <jet-label for="course_id" :value="$t('course_id')" />
                <v-select
                    id="course_id"
                    v-model="form.course_id"
                    :options="mdl_courses"
                    :reduce="courses => courses.id"
                />
            </div>

            <div class="col-span-12">
                <jet-label for="name_en" :value="$t('course_name_en')" />
                <jet-input id="name_en" type="text" class="mt-1 block w-full" v-model="form.course_name_en" />
            </div>

            <div class="col-span-12">
                <jet-label for="name_fr" :value="$t('course_name_fr')" />
                <jet-input id="name_fr" type="text" class="mt-1 block w-full" v-model="form.course_name_fr" />
            </div>

            <div class="col-span-12">
                <jet-label for="description_en" :value="$t('description_en')" />
                <textarea
                    id="description_en"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 rounded-md shadow-sm
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.description_en"></textarea>
            </div>

            <div class="col-span-12">
                <jet-label for="description_fr" :value="$t('description_fr')" />
                <textarea
                    id="description_fr"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 rounded-md shadow-sm
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.description_fr"></textarea>
            </div>

            <div class="col-span-12">
                <jet-label for="category" :value="$t('category')" />
                <v-select
                    id="category"
                    v-model="form.category_id"
                    :options="categories"
                    :reduce="category => category.id"
                />
            </div>

            <div class="col-span-12">
                <jet-label for="language" :value="$t('languages')" />
                <v-select
                    id="language"
                    multiple
                    v-model="form.language_ids"
                    :options="languages"
                    :reduce="language => language.id"
                />
            </div>

            <div class="col-span-12">
                <jet-label for="publish_date" :value="$t('publish_date')" />
                <jet-input id="publish_date" type="date" class="mt-1 block w-full" v-model="form.publish_date" />
            </div>

            <div class="col-span-12">
                <jet-label for="presenters" :value="$t('presenters')" />
                <v-select id="presenters" multiple v-model="form.presenters" taggable />
            </div>

            <div class="col-span-12">
                <jet-label for="keywords_en" :value="$t('keywords_en')" />
                <v-select id="keywords_en" multiple v-model="form.keywords_en" taggable />
            </div>

            <div class="col-span-12">
                <jet-label for="keywords_fr" :value="$t('keywords_fr')" />
                <v-select id="keywords_fr" multiple v-model="form.keywords_fr" taggable />
            </div>

            <div class="col-span-12">
                <jet-label for="min_estimated_time_days" :value="$t('min_estimated_time')" />
                <div class="flex w-full items-center justify-between mt-2">
                    <div class="flex-1 mr-2">
                        <jet-label for="min_estimated_time_days" :value="$t('days')" />
                        <jet-input
                            id="min_estimated_time_days"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.min_estimated_time.days"
                        />
                    </div>
                    <div class="flex-1 mr-2">
                        <jet-label for="min_estimated_time_hours" :value="$t('hours')" />
                        <jet-input
                            id="min_estimated_time_hours"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.min_estimated_time.hours"
                        />
                    </div>
                    <div class="flex-1">
                        <jet-label for="min_estimated_time_minutes" :value="$t('minutes')" />
                        <jet-input
                            id="min_estimated_time_minutes"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.min_estimated_time.minutes"
                        />
                    </div>
                </div>
            </div>

            <div class="col-span-12">
                <jet-label for="max_estimated_time_days" :value="$t('max_estimated_time')" />
                <div class="flex w-full items-center justify-between mt-2">
                    <div class="flex-1 mr-2">
                        <jet-label for="max_estimated_time_days" :value="$t('days')" />
                        <jet-input
                            id="max_estimated_time_days"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.max_estimated_time.days"
                        />
                    </div>
                    <div class="flex-1 mr-2">
                        <jet-label for="max_estimated_time_hours" :value="$t('hours')" />
                        <jet-input
                            id="max_estimated_time_hours"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.max_estimated_time.hours"
                        />
                    </div>
                    <div class="flex-1">
                        <jet-label for="max_estimated_time_minutes" :value="$t('minutes')" />
                        <jet-input
                            id="max_estimated_time_minutes"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.max_estimated_time.minutes"
                        />
                    </div>
                </div>
            </div>

            <div class="col-span-12">
                <div class="flex items-center mb-2">
                    <input
                        id="objectives_active"
                        type="radio"
                        class="mr-2"
                        v-model="objectivesOrTopics"
                        value="objectives"
                    />
                    <label class="font-medium text-sm text-gray-700 mr-6" for="objectives_active">{{ $t('objectives') }}</label>

                    <input
                        id="topics_active"
                        type="radio"
                        class="mr-2"
                        v-model="objectivesOrTopics"
                        value="topics"
                    />
                    <label class="font-medium text-sm text-gray-700" for="topics_active">{{ $t('topics_covered') }}</label>
                </div>

                <div >
                    <jet-label v-if="objectivesOrTopics === 'objectives'" :value="$t('objectives_en')" />
                    <jet-label v-else :value="$t('topics_en')" />
                    <jet-input
                        v-for="index in Object.keys(form.objectives_topics.english)"
                        :id="`objective_en_${index}`"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.objectives_topics.english[index]" />

                    <jet-label v-if="objectivesOrTopics === 'objectives'" class="mt-2" :value="$t('objectives_fr')" />
                    <jet-label v-else class="mt-2" :value="$t('topics_fr')" />
                    <jet-input
                        v-for="index in Object.keys(form.objectives_topics.french)"
                        :id="`objective_fr_${index}`"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.objectives_topics.french[index]" />
                </div>

                <button
                    type="button"
                    class="bg-gray-800 mt-2 border border-transparent rounded-full w-8 h-8 text-white font-bold text-lg"
                    @click="addNewObjectiveOrTopic"
                >
                    +
                </button>
            </div>
        </template>

        <template #actions>
            <jet-button>
                {{ $t('save') }}
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import vSelect from 'vue-select';
import "vue-select/dist/vue-select.css";

export default {
    name: 'CourseMetadataForm',

    props: {
        categories: Array,
        languages: Array,
        mdl_courses: Array,
        metadata: Object
    },

    components: {
        JetButton,
        JetFormSection,
        JetInputError,
        JetInput,
        JetLabel,
        JetSecondaryButton,
        vSelect
    },

    data() {
        return {
            objectivesOrTopics: 'objectives',
            form: {
                course_id: null,
                course_name_en: '',
                course_name_fr: '',
                category_id: null,
                language_ids: [],
                publish_date: '',
                presenters: [],
                keywords_en: [],
                keywords_fr: [],
                min_estimated_time: {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                },
                max_estimated_time: {
                    days: 0,
                    hours: 0,
                    minutes: 0,
                },
                objectives_topics: {
                    english: [''],
                    french: ['']
                },
            },
        }
    },

    created() {
        if (Object.keys(this.metadata).length) this.fillForm();
    },

    methods: {
        submit() {
            this.$inertia.post('/moodle-courses', this.form);
        },

        addNewObjectiveOrTopic() {
            this.form.objectives_topics.english.push('');
            this.form.objectives_topics.french.push('');
        },

        fillForm() {
            this.form.course_id = this.metadata.course_id;
            this.form.course_name_en = this.metadata.course_name_en;
            this.form.course_name_fr = this.metadata.course_name_fr;
            this.form.category_id = this.metadata.category_id;
            this.form.language_ids = this.metadata.language_ids;
            this.form.publish_date = this.metadata.publish_date;
            this.form.presenters = this.metadata.presenters;
            this.form.keywords_en = this.metadata.keywords_en;
            this.form.keywords_fr = this.metadata.keywords_fr;
            this.form.min_estimated_time = this.metadata.min_estimated_time;
            this.form.max_estimated_time = this.metadata.max_estimated_time;
            this.form.objectives_topics = this.metadata.objectives_topics;
            this.form.description_en = this.metadata.description_en;
            this.form.description_fr = this.metadata.description_fr;
        }
    }
}
</script>
