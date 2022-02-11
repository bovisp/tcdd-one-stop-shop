<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
           :value="modelValue"
           :disabled="disabled"
           @input="$emit('update:modelValue', $event.target.value)"
           ref="input">
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            modelValue: {
                required: true
            },
            disabled: Boolean
        },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>
