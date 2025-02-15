<script setup>
import dashboard from "../../images/dashboard.png";
</script>

<template>
    <MainLayout :isDashboard="true">
        <img :src="dashboard" class="max-h-screen max-w-screen" />
    </MainLayout>
</template>
