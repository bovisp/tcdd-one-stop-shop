<template>
    <div class="flex flex-col">
        <div class="flex py-3 px-4 bg-gray-100 justify-end">
            <span class="text-sm text-gray-600">
                <a v-if="$i18n.locale === 'fr'" href="#" @click="setLocale('en')">EN</a>
                <a v-else href="#" @click="setLocale('fr')">FR</a>
            </span>
        </div>
        <jet-authentication-card>
            <template #logo>
                <jet-authentication-card-logo />
            </template>

            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <jet-label for="email" :value="$t('email')" />
                    <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />
                </div>

                <div class="mt-4">
                    <jet-label for="password" :value="$t('password')" />
                    <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <jet-checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ $t('remember_me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ $t('forgot_password') }}
                    </Link>

                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        {{ $t('login') }}
                    </jet-button>
                </div>
            </form>
        </jet-authentication-card>
    </div>

</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            },

            setLocale(locale) {
                this.$i18n.locale = locale;

                localStorage.setItem('tcdd:language', locale);
            }
        }
    })
</script>
