<script setup></script>

<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Targets</Heading>
            <Link
                :href="route('targets.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New Target</Link
            >
        </DivFlexCenter>

  
    </MainLayout>
</template>
