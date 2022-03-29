<template>
        {{ $t('add_moodle_catalogue') }}
    <div class="mt-5">


    <form @submit.prevent="submit">
        <input type="file" @input="form.catalogue = $event.target.files[0]" />
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
        </progress>
        <div>

            <button type="submit"
                    class="bg-gray-800 mt-2 border border-transparent rounded-full w-8 h-8 text-white font-bold text-lg"

            >Submit</button>
        </div>
    </form>
    </div>
</template>

<script>
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {
        setup () {
            const form = useForm({
                catalogue: null,
            })

            function submit() {
                form.post('/course-catalogues')
            }

            return { form, submit }
        },
    }
</script>