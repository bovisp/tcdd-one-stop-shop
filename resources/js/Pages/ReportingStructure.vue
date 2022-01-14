<template>
    <app-layout title="User Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ profile.name }}'s info
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <jet-action-section>
                        <template #title>
                            User information
                        </template>

                        <template #content>
                            <div class="max-w-xl text-sm text-gray-600">
                                <p>Name: {{ profile.name }}</p>
                                <p>E-mail: {{ profile.email }}</p>
                                <p>Section: {{ profile.section || '---' }}</p>
                            </div>
                        </template>
                    </jet-action-section>

                    <jet-section-border />

                    <jet-action-section>
                        <template #title>
                            Reporting Structure
                        </template>

                        <template #content>
                            <div class="max-w-xl text-sm text-gray-600">
                                <div v-if="reporting_structure">
                                    <div v-for="position in reporting_structure" :key="`hierarchy-${1}`">
                                        <h1 class="text-lg">{{ position.role.name }}</h1>
                                        <ul v-if="position.users.length">
                                            <li
                                                v-for="user in position.users"
                                                :key="`user_profile_link-${user.id}`"
                                                class="px-4 py-1"
                                            >
                                                <a :href="`/users/${user.id}/reporting-structure`" class="text-sm text-gray-700 underline">
                                                    {{ user.name }}
                                                </a>
                                            </li>
                                        </ul>
                                        <p v-else class="ml-4">---</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </jet-action-section>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: {
        profile: Object,
        reporting_structure: Object
    },
    components: {
        AppLayout,
        JetActionSection,
        JetSectionBorder,
        Link
    },
    created() {
        console.log(this.reporting_structure)
    }
 })
</script>
