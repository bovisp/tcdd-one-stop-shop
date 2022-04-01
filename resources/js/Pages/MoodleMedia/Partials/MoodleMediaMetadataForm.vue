<template>
    <jet-form-section  @submitted="submit">
        <template #title>
            {{ $t('moodle_media') }}
        </template>

        <template #form >
            <div class="col-span-12">
                <jet-label for="title_en" :value="$t('media_title_en')" />
                <jet-input id="title_en" type="text" class="mt-1 block w-full" v-model="form.title_en" required/>
            </div>
            <div class="col-span-12">
                <jet-label for="title_fr" :value="$t('media_title_fr')" />
                <jet-input id="title_fr" type="text" class="mt-1 block w-full" v-model="form.title_fr" required/>
            </div>

            <div class="col-span-12">
                <jet-label for="media" :value="$t('media')" />
                <jet-input id="media" type="file" class="mt-1 block w-full" v-model="form.media" required/>
            </div>

            <div class="col-span-12">
                <jet-label for="description_en" :value="$t('media_description_en')" />
                <textarea
                    id="description_en"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 rounded-md shadow-sm
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.description_en" required></textarea>
            </div>

            <div class="col-span-12">
                <jet-label for="description_fr" :value="$t('media_description_fr')" />
                <textarea
                    id="description_fr"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 rounded-md shadow-sm
                        focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    v-model="form.description_fr" required></textarea>
            </div>


            <div class="col-span-12">
                <jet-label for="license" :value="$t('license_id')" />
                <v-select
                    id="license_id"
                    v-model="form.license_id"
                    :options="licenses"
                    :reduce="license => license.id"
                />
            </div>


            <div class="col-span-12">
                <jet-label for="keywords_en" :value="$t('keywords_en')" />
                <v-select id="keywords_en" multiple v-model="form.keywords_en" taggable />
            </div>

            <div class="col-span-12">
                <jet-label for="keywords_fr" :value="$t('keywords_fr')" />
                <v-select id="keywords_fr" multiple v-model="form.keywords_fr" taggable />
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
        licenses :Array,
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
            form: {
                media:'',
                title_en: '',
                title_fr: '',
                license_id: null,
                keywords_en: '',
                keywords_fr: '',
                description_en: [],
                description_fr: [],
            },
        }
    },
    // created() {
    //     if (Object.keys(this.metadata).length) this.fillForm();
    // },

    methods: {
        submit() {
            if (Object.keys(this.metadata).length) {
                this.$inertia.patch(`/moodle-media/${this.metadata.id}`, this.form);
            } else {
                this.$inertia.post('/moodle-media', this.form);
            }
        },
        fillForm() {
            this.form.title_en = this.metadata.title_en;
            this.form.title_fr = this.metadata.title_fr;
            this.form.license_id = this.metadata.license_id;
            this.form.keywords_en = this.metadata.keywords_en;
            this.form.keywords_fr = this.metadata.keywords_fr;
            this.form.description_en = this.metadata.description_en;
            this.form.description_fr = this.metadata.description_fr;
        }
    }
}
</script>
