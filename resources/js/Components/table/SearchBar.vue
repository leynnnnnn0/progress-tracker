<script setup>
import { Search } from "lucide-vue-next";
</script>
<template>
    <div class="relative w-full sm:max-w-sm items-center">
        <slot></slot>
        <span
            class="absolute start-0 inset-y-0 flex items-center justify-center px-2"
        >
            <Search class="size-6 text-muted-foreground" />
        </span>
    </div>
</template>
