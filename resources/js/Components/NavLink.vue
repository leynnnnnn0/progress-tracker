<script setup>
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const isActive = (route) => {
    const currentUrl = usePage().url;

    if (currentUrl === route) {
        return true;
    }

    if (currentUrl.startsWith(route + "/")) {
        const remainingPath = currentUrl.substring(route.length + 1);
        return !remainingPath.includes("/");
    }

    return false;
};

defineProps({
    href: {
        type: String,
        required: true,
    },
    icon: {
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="flex items-center gap-3 rounded-l-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
        :class="{ 'text-primary bg-primary/10': isActive(href) }"
    >
        <component :is="icon" class="h-4 w-4" />
        <slot></slot>
    </Link>
</template>
