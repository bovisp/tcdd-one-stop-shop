<template>
    <div v-for="item in items" >
    <div class="container mt-32 mx-auto p-4 md:p-0">
            <!--Card 1-->
            <div class=" shadow-lg flex flex-wrap w-full lg:w-4/5 mx-auto">
                <div class="border-r border-b border-l border-gray-400 lg:border-l-0 lg:border-t lg:border-gray-400 bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                    <div class="bg-white w-full md:w-2/3">
                        <img src="{{ item.media }}" alt="media">

                    </div>
                    <div class="w-full lg:w-1/5 lg:border-right lg:border-solid text-center md:text-left">
                        <div class="text-gray-900 font-bold text-xl mb-2">
                            {{ item.title.english }} /  {{ item.title.french }}
                        </div>
                        <p class="text-gray-700 text-base">
                            {{ item.description.english }}  / {{ item.description.french }}
                        </p>
                        <p class="text-gray-700 text-base">
                            License: {{ item.moodleMediaLicense.en }} / {{ item.moodleMediaLicense.fr }}
                        </p>
                        <p class="text-gray-700 text-base">
                            {{ item.keywords.english }} / {{ item.keywords.french }}

                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="text-sm">
                            <a href="#" @click="$emit('edit', item.id)">{{ $t('edit') }}</a>
                            <a href="#" class="text-red-500 underline ml-2" @click="$emit('delete', item.id)">
                            {{ $t('delete') }}
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: 'List',

    props: ['items'],
}
</script>

<style scoped>
."w-1/2" {
    width: 50%;
}
</style>
