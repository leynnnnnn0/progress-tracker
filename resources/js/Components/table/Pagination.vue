<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    data: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div v-if="data.data.length === 0" class="p-5 flex justify-center w-full">
        Nothing to show
    </div>
    <div v-else class="flex items-center justify-end gap-2">
        <template v-for="(link, index) in data.links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                preserve-scroll
                preserve-state
                class="px-3 py-1 border border-gray-200 text-primary-font font-bold rounded-lg sm:text-sm text-xs"
                :class="{
                    'bg-primary text-white': link.active,
                    'hover:bg-primary/50 transition-colors duration-300':
                        !link.active,
                }"
                v-html="link.label"
            />
            <span
                v-else
                class="px-3 py-1 border border-gray-200 text-gray-400 font-bold rounded-lg sm:text-sm text-xs"
                v-html="link.label"
            />
        </template>
    </div>
</template>
