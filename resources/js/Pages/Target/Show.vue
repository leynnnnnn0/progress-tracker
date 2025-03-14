<script setup>
defineProps({
    target: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <Heading>Target Details</Heading>
        <FormContainer>
            <Infolist label="Description" :value="target.description" />
            <Infolist
                label="Percentage Group"
                :value="target.percentage_group"
            />
            <h1 class="col-span-2 text-xs">Sub Targets</h1>
            <ul>
                <li v-for="sub_target in target.sub_targets" class="font-bold">
                    {{ sub_target.description }}
                </li>
            </ul>
        </FormContainer>
    </MainLayout>
</template>
