<template>
    <div class="py-2 align-middle inline-block w-full">
        <div class="shadow border-b border-gray-200 sm:rounded-lg max-w-full">
            <table class="w-full table-fixed divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('title') }}
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('language') }}
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('topics') }}
                        </th>
                         <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $t('publish_date') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="w-full" v-if="!items.data.length">
                        <td class="flex w-full items-center justify-center h-10 text-sm font-medium text-gray-900">
                            --
                        </td>
                    </tr>
                    <template v-else>
                        <tr v-for="item in items.data">
                            <td class="p-4 break-normal">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.title }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.language }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <ul class="text-sm font-medium text-gray-900">
                                        <li v-for="cat in item.categories" >
                                            {{ cat.en }} / {{ cat.fr }}
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ item.publish_date }}
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components:{
          Link,
        },

        name: 'List',

        props: ['items'],
}
</script>
