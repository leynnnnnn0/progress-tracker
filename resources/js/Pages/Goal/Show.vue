<script setup>
defineProps({
    goal: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <Heading>Goal Details</Heading>
        <FormContainer>
            <Infolist label="Description" :value="goal.description" />

            <h1 class="col-span-2 text-xs font-semibold mt-4 mb-2">
                Objectives
            </h1>
            <div class="col-span-2">
                <div v-if="goal.objectives && goal.objectives.length > 0">
                    <ul class="list-disc pl-5 space-y-2">
                        <li
                            v-for="objective in goal.objectives"
                            :key="objective.id"
                            class="font-bold text-sm"
                        >
                            {{ objective.description }}
                        </li>
                    </ul>
                </div>
                <div v-else class="text-gray-500 italic text-sm">
                    No objectives defined for this goal.
                </div>
            </div>
        </FormContainer>

        <BackButton />
    </MainLayout>
</template>
