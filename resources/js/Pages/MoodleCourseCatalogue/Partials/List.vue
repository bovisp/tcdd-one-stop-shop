<template>
    <div class="py-2 align-middle inline-block w-full">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            language
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Topics
                        </th>
                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Publish Date
                        </th>
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
                            <td class="px-6 py-4 whitespace-nowrap truncate">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900 ">
                                        <!--{{ item.title }}-->
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div  class="text-sm font-medium text-gray-900">
                                        {{ item.language }}

                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ item.category.en }} / {{ item.category.fr }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
export default {
    name: 'List',

        props: ['items'],
}
</script>

<style scoped>
."w-1/2" {
    width: 50%;
}
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    /*white-space: nowrap;*/
}
</style>
