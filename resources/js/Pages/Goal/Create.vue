<script setup>
import { useForm } from "@inertiajs/vue3";
import useStore from "@/Composables/useStore";
import Dialog from "primevue/dialog";
import { ref } from "vue";

const form = useForm({
    description: null,
    objectives: [],
});

const { store } = useStore(form, route("goals.store"), "Goal");

const isObjectiveModalOpen = ref(false);
const isObjectiveEditModalOpen = ref(false);
const objectiveInput = ref("");
const objectiveId = ref(null);

const openObjectiveModal = () => {
    isObjectiveModalOpen.value = true;
};

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

const deleteObjective = (id) => {
    form.objectives = form.objectives.filter((item) => item.id !== id);
};

const editObjective = (id) => {
    objectiveId.value = id;
    const objective = form.objectives.find((item) => item.id === id);
    objectiveInput.value = objective.description;
    isObjectiveEditModalOpen.value = true;
};

const updateObjective = () => {
    if (objectiveInput.value) {
        const index = form.objectives.findIndex(
            (item) => item.id === objectiveId.value
        );
        form.objectives[index].description = objectiveInput.value;
        isObjectiveEditModalOpen.value = false;
        objectiveInput.value = "";
    }
};
</script>

<template>
    <MainLayout>
        <Heading>Create New Goal</Heading>

        <FormContainer>
            <FormInput
                class="col-span-2"
                label="Description"
                :errorMessage="form.errors.description"
            >
                <Textarea v-model="form.description" />
            </FormInput>
        </FormContainer>

        <TableContainer>
            <TableHeader>
                <Button @click="openObjectiveModal" class="text-white"
                    >Add Objective</Button
                >
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
            <Button @click="store" class="text-white">Create Goal</Button>
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
