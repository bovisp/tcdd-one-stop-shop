<template>
    <div class="py-2 align-middle inline-block w-full">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-1/2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('name') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('category') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('publish_date') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="w-full" v-if="!items.length">
                        <td class="flex w-full items-center justify-center h-10 text-sm font-medium text-gray-900">
                            --
                        </td>
                    </tr>
                    <template v-else>
                        <tr v-for="item in items">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div v-if="$i18n.locale === 'en'" class="text-sm font-medium text-gray-900">
                                        {{ item.course_name_en }}
                                    </div>
                                    <div v-if="$i18n.locale === 'fr'" class="text-sm font-medium text-gray-900">
                                        {{ item.course_name_fr }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.category[$i18n.locale] }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ item.publish_date }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm underline">
                                <a href="#" @click="$emit('details', item.id)">{{ $t('details') }}</a>
                                <a href="#" class="text-red-500 underline ml-2" @click="$emit('delete', item.id)">
                                    {{ $t('delete') }}
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
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
