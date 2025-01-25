<script setup>
import { usePage, router } from "@inertiajs/vue3";

const backButton = () => {
    router.get(usePage().props.previous);
};
</script>
<template>
    <Button
        variant="outline"
        class="sm:text-lg px-7 text-xs w-fit"
        @click="backButton"
    >
        Back
    </Button>
</template>
