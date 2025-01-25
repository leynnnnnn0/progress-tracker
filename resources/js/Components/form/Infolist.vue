<script setup>
defineProps({
    label: String,
    value: {
        required: true,
    },
});
</script>
<template>
    <InputContainer>
        <SpanXS>{{ label }}</SpanXS>
        <SpanBold>{{ value }}</SpanBold>
    </InputContainer>
</template>
