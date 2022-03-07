<template>
    <jet-form-section  @submitted="submit">
        <template #title>
            Register new webinar attendance
        </template>

        <template #form>
            <div class="col-span-12">
                <jet-label for="fiscal_year" value="Fiscal year" />
                <select
                    id="fiscal_year"
                    class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    name="fiscal_year"
                    v-model="form.fiscal_year_id"
                >
                    <option value="0"></option>
                    <option
                        v-for="year in fiscalYears"
                        :value="year.id"
                        :key="`year-${year.id}`"
                    >
                        {{ year.label }}
                    </option>
                </select>
            </div>

            <div class="col-span-12">
                <jet-label for="quarter" value="Quarter" />
                <select
                    id="quarter"
                    class="mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    name="quarter"
                    v-model="form.quarter_id"
                >
                    <option value="0"></option>
                    <option
                        v-for="quarter in quarters"
                        :value="quarter.id"
                        :key="`quarter-${quarter.id}`"
                    >
                        {{ quarter.label }}
                    </option>
                </select>
            </div>

            <div v-for="(attendance, index) in form.attendance" class="col-span-12">
                <div class="flex w-full">
                    <div>
                        <jet-label :for="`language${index}`" value="Language" />
                        <select
                            :id="`language${index}`"
                            class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            :name="`language${index}`"
                            v-model="form.attendance[index].language_id"
                        >
                            <option value="0"></option>
                            <option
                                v-for="language in languages"
                                :value="language.id"
                                :key="`language-${index}-${language.id}`"
                            >
                                {{ language.label }}
                            </option>
                        </select>
                    </div>
                    <div class="ml-4 flex-1">
                        <jet-label :for="`language_name${index}`" value="Name" />
                        <jet-input
                            :id="`language_name${index}`"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.attendance[index].name"
                        />
                    </div>
                    <div class="ml-4">
                        <jet-label :for="`attendance${index}`" value="Attendance" />
                        <jet-input
                            :id="`attendance${index}`"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.attendance[index].attendance"
                        />
                    </div>
                </div>
            </div>

            <button
                @click="addAttendanceLine"
                type="button"
                class="bg-gray-800 border border-transparent rounded-full w-8 h-8 text-white font-bold text-lg"
            >
                +
            </button>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
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
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

export default {
    name: 'AttendanceForm',

    props: ['fiscalYears', 'languages', 'quarters'],

    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInputError,
        JetInput,
        JetLabel,
        JetSecondaryButton,
    },

    data() {
        return {
            form: {
                fiscal_year_id: '',
                quarter_id: '',
                attendance: [
                    { language_id: '', name: '', attendance: 0 }
                ],
            },
        }
    },

    methods: {
        submit() {
            this.$inertia.post('/webinar-attendance', this.form);
        },
        addAttendanceLine() {
            if (this.form.attendance.length >= this.languages.length) {
                return;
            }

            this.form.attendance.push({ language_id: '', name: '', attendance: 0 });
        }
    },
}
</script>
