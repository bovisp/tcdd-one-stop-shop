<template>
    <div class="w-full flex flex-col">
        <div class="w-full">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Fiscal Year
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Attendance
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, key) in items">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ key }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-right text-gray-900">{{ item }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Total
                            </td>
                            <td class="px-6 py-3 font-bold">
                                <div class="text-sm text-right text-gray-900">{{ total }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TablePerFiscalYear',

    props: ['items'],

    data() {
        return {
            total: Object.values(this.items).reduce((acc, value) => acc + value, 0),
        }
    }
}
</script>
