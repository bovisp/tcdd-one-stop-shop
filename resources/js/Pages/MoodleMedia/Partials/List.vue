<template>
    <div>
        <div class="mt-3" v-for="item in items">
            <div class="mx-auto p-4 md:p-0">
                <div class="shadow-lg flex flex-wrap w-full">
                    <div class="w-full p-4 flex justify-between leading-normal">
                        <img class="object-cover h-20 w-20 rounded" :src="item.media" alt="media">
                        <div class="flex-1 ml-4 mr-4">
                            <div v-if="$i18n.locale === 'en'" class="text-gray-900 font-bold text-xl">
                                {{ item.title.english }}
                            </div>
                            <div v-if="$i18n.locale === 'fr'" class="text-gray-900 font-bold text-xl">
                                {{ item.title?.french }}
                            </div>
                            <p v-if="$i18n.locale === 'en'" class="text-gray-700 text-base">
                                {{ item.description?.english.substring(0,199) }}
                            </p>
                            <p v-if="$i18n.locale === 'fr'" class="text-gray-700 text-base">
                                {{ item.description?.french.substring(0,199) }}
                            </p>
                            <p class="text-gray-700 text-base">
                                License: {{ item.moodleMediaLicense[$i18n.locale] }}
                            </p>
                            <div v-if="$i18n.locale === 'en'" class="flex text-gray-700 text-base">
                            <span
                                v-for="key in item.keywords.english"
                                class="mr-4 bg-gray-200 px-2 py-1 rounded-lg"
                            >
                                {{ key }}
                            </span>
                            </div>
                            <div v-if="$i18n.locale === 'fr'" class="flex text-gray-700 text-base">
                            <span
                                v-for="key in item.keywords.french"
                                class="mr-4 bg-gray-200 px-2 py-1 rounded-lg"
                            >
                                {{ key }}
                            </span>
                            </div>
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
    </div>
</template>

<script>
export default {
    name: 'List',

    props: ['items'],
}
</script>
