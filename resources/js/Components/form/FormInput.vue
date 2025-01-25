<script setup>
defineProps({
    isRequired: {
        type: Boolean,
        default: true,
    },
    label: {
        type: String,
        required: true,
    },
    errorMessage: {
        required: false,
        type: String,
    },
});
</script>
<template>
    <InputContainer>
        <InputLabel :label="label" :isRequired="isRequired" />
        <slot />
        <FormError>{{ errorMessage }}</FormError>
    </InputContainer>
</template>
