<template>
    <Link :href="'/'">
        <div class="w-full">
<!--            <img src="/images/logo.png" alt="logo">-->
        </div>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>
