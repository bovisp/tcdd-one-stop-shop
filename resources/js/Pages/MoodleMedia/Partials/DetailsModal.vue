<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-20 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-3">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-2 text-center sm:mt-0 sm:text-left w-full">
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('media_metadata') }}
                                    </h3>
                                </div>
                                <div class="border-t border-gray-200">
                                    <dl>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ $t('title') }}
                                            </dt>
                                            <dd class="mt-4 text-sm text-gray-900 sm:mt-0 sm:col-span-2 sm:text-right italic">
                                                <span v-if="$i18n.locale === 'en'">{{ item.media_title_en }}</span>
                                                <span v-else>{{ item.media_title_fr }}</span>
                                            </dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                Description
                                            </dt>
                                            <dd class="mt-4 text-sm text-gray-900 sm:mt-0 sm:col-span-2 sm:text-right italic">
                                                <span v-if="$i18n.locale === 'en'">{{ item.description_en }}</span>
                                                <span v-else>{{ item.description_fr }}</span>
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ $t('license') }}
                                            </dt>
                                            <dd class="mt-4 text-sm text-gray-900 sm:mt-0 sm:col-span-2 sm:text-right italic">
                                                <span>{{ item.license }}</span>
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                Keywords
                                            </dt>
                                            <dd class="mt-4 text-sm text-gray-900 sm:mt-0 sm:col-span-2 sm:text-right italic">
                                                <span>{{ item.keywords }}</span>
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                Media
                                            </dt>
                                        <dd class="mt-4 text-sm text-gray-900 sm:mt-0 sm:col-span-2 sm:text-right italic">
                                            <span>{{ item.media }}</span>
                                        </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-3 py-3 sm:flex sm:flex-row-reverse">
                    <button
                        type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="$emit('close')"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DetailsModal',

    props: {
        item: Object
    },
}
</script>
