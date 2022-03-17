<template>
    <div>
        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-20">
                        <div class="flex h-full">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <Link class="w-48" :href="route('dashboard')">
                                    <jet-application-mark class="block h-auto w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                    {{ $t('dashboard') }}
                                </jet-nav-link>
                                <jet-nav-link
                                    :href="route('webinar-attendance.dashboard')"
                                    :active="route().current('webinar-attendance.dashboard')"
                                >
                                    {{ $t('webinar_attendance') }}
                                </jet-nav-link>
                                <jet-nav-link
                                    :href="route('moodle-courses.index')"
                                    :active="route().current('moodle-courses.index')"
                                >
                                    {{ $t('moodle_courses') }}
                                </jet-nav-link>
                                <jet-nav-link
                                        :href="route('moodle-media.index')"
                                        :active="route().current('moodle-media.index')"
                                >
                                    {{ $t('moodle_media') }}
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <span class="text-sm text-gray-600">
                                <a v-if="$i18n.locale === 'fr'" href="#" @click="setLocale('en')">EN</a>
                                <a v-else href="#" @click="setLocale('fr')">FR</a>
                            </span>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            {{ $page.props.username }}
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.username }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ $t('account_management') }}
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            {{ $t('profile') }}
                                        </jet-dropdown-link>

                                        <jet-dropdown-link
                                            v-if="$page.props.show_reporting_structure"
                                            :href="`/users/${$page.props.user.id}/reporting-structure`"
                                            :active="route().current('nova')"
                                        >
                                            {{ $t('my_reporting_structure') }}
                                        </jet-dropdown-link>

                                        <a v-if="$page.props.user.is_admin"
                                            href="/nova/resources/users"
                                            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                            Admin
                                        </a>

                                        <div class="border-t border-gray-100"></div>

                                        <form @submit.prevent="logout">
                                            <jet-dropdown-link as="button">
                                                {{ $t('logout') }}
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                            {{ $t('dashboard') }}
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link
                            v-if="$page.props.show_reporting_structure"
                            :href="`/users/${$page.props.user.id}/reporting-structure`"
                            :active="route().current('nova')"
                        >
                            {{ $t('my_reporting_structure') }}
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link v-if="$page.props.user.is_admin" href="/nova" :active="route().current('nova')">
                            Admin
                        </jet-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>
                                <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                {{ $t('profile') }}
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <jet-responsive-nav-link as="button">
                                    {{ $t('logout') }}
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
    import JetBanner from '@/Jetstream/Banner.vue';
    import JetDropdown from '@/Jetstream/Dropdown.vue';
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
    import JetNavLink from '@/Jetstream/NavLink.vue';
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            setLocale(locale) {
                this.$i18n.locale = locale;

                localStorage.setItem('tcdd:language', locale);
            },

            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    })
</script>
