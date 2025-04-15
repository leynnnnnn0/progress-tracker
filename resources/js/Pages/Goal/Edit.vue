<script setup>
import Dialog from "primevue/dialog";
import useUpdate from "@/Composables/useUpdate";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const { goal } = defineProps({
    goal: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    description: goal.description,
    objectives: [],
});

// Initialize form with existing objectives
goal.objectives.map((item) => {
    form.objectives.push({
        id: item.id,
        description: item.description,
    });
});

// Modal state management
const isObjectiveModalOpen = ref(false);
const isObjectiveEditModalOpen = ref(false);
const objectiveInput = ref("");
const objectiveId = ref(null);

// Open modal for adding new objective
const openObjectiveModal = () => {
    isObjectiveModalOpen.value = true;
};

// Add objective to the form data
const addObjective = () => {
    if (objectiveInput.value) {
        const uid =
            Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
        form.objectives.push({
            id: uid,
            description: objectiveInput.value,
        });
        isObjectiveModalOpen.value = false;
        objectiveInput.value = "";
    }
};

// Delete objective from form data
const deleteObjective = (id) => {
    form.objectives = form.objectives.filter((item) => item.id != id);
};

// Open edit modal with selected objective data
const editObjective = (id) => {
    objectiveId.value = id;
    isObjectiveEditModalOpen.value = true;
    const objective = form.objectives.find((item) => item.id == id);
    objectiveInput.value = objective.description;
};

// Update objective in form data
const updateObjective = () => {
    if (objectiveInput.value) {
        const index = form.objectives.findIndex(
            (item) => item.id == objectiveId.value
        );
        form.objectives[index].description = objectiveInput.value;
        isObjectiveEditModalOpen.value = false;
        objectiveInput.value = "";
    }
};

const { update } = useUpdate(form, route("goals.update", goal.id), "Goal");
</script>

<template>
    <MainLayout>
        <Heading>Edit Goal</Heading>
        <FormContainer>
            <FormInput
                label="Description"
                class="col-span-2"
                :errorMessage="form.errors.description"
            >
                <Textarea v-model="form.description" />
            </FormInput>
        </FormContainer>

        <TableContainer>
            <TableHeader>
                <Button @click="openObjectiveModal" class="text-white">
                    Add Objective
                </Button>
            </TableHeader>
            <Table>
                <TableHead>
                    <TH>Description</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr
                        v-for="objective in form.objectives"
                        :key="objective.id"
                    >
                        <TD>{{ objective.description }}</TD>
                        <TD>
                            <DivFlexCenter class="gap-2">
                                <EditButton
                                    @click="editObjective(objective.id)"
                                />
                                <DeleteButton
                                    @click="deleteObjective(objective.id)"
                                />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
        </TableContainer>

        <DivFlexCenter class="justify-end mt-4">
            <Link :href="route('goals.show', goal.id)" class="mr-2">
                <Button type="button" class="bg-gray-500 text-white"
                    >Cancel</Button
                >
            </Link>
            <Button @click="update" class="text-white">Update Goal</Button>
        </DivFlexCenter>

        <!-- Add Objective Modal -->
        <Dialog
            v-model:visible="isObjectiveModalOpen"
            modal
            :style="{ width: '30rem' }"
        >
            <template #header>Add Objective</template>
            <DivFlexCol>
                <FormInput label="Description">
                    <Textarea v-model="objectiveInput" />
                </FormInput>
            </DivFlexCol>
            <DivFlexCenter class="justify-end">
                <Button @click="addObjective" class="text-white">Add</Button>
            </DivFlexCenter>
        </Dialog>

        <!-- Edit Objective Modal -->
        <Dialog
            v-model:visible="isObjectiveEditModalOpen"
            modal
            :style="{ width: '30rem' }"
        >
            <template #header>Edit Objective</template>
            <DivFlexCol>
                <FormInput label="Description">
                    <Textarea v-model="objectiveInput" />
                </FormInput>
            </DivFlexCol>
            <DivFlexCenter class="justify-end">
                <Button @click="updateObjective" class="text-white"
                    >Update</Button
                >
            </DivFlexCenter>
        </Dialog>
    </MainLayout>
</template>
