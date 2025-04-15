<script setup>
const { objectives } = defineProps({
    objectives: {
        type: Object,
        required: true,
    },
});
import useDelete from "@/Composables/useDelete.js";
import Textarea from "@/Components/ui/textarea/Textarea.vue";
import useStore from "@/Composables/useStore";
import useUpdate from "@/Composables/useUpdate";
import { useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import useAlert from "@/Composables/useAlert.js";
const { confirm, toast } = useAlert();
const { deleteModel } = useDelete("Objective");
// Create modal controls
const isCreateModalVisible = ref(false);

const openCreateModal = () => {
    isCreateModalVisible.value = true;
};

const form = useForm({
    description: null,
});

const { store } = useStore(form, route("objectives.store"), "Objective");

const createModel = async () => {
    const result = await store();
    if (result) {
        isCreateModalVisible.value = false;
        form.reset();
    }
};

// Update modal controls
const isUpdateModalVisible = ref(false);
const currentObjectiveId = ref(null);

const updateForm = useForm({
    description: null,
});

const openUpdateModal = (objective) => {
    currentObjectiveId.value = objective.id;
    updateForm.description = objective.description;
    isUpdateModalVisible.value = true;
    console.log(currentObjectiveId.value);
};

const updateModel = async () => {
    new Promise((resolve) => {
        confirm.require({
            message: `Are you sure you want to update this objective?`,
            header: "Confirmation",
            icon: "pi pi-exclamation-triangle",
            rejectProps: {
                label: "Cancel",
                severity: "secondary",
                outlined: true,
            },
            acceptProps: {
                label: "Confirm",
                severity: "success",
            },
            accept: () => {
                updateForm.put(
                    route("objectives.update", currentObjectiveId.value),
                    {
                        onSuccess: () => {
                            toast.add({
                                severity: "success",
                                summary: "Success",
                                detail: `Objective Updated Successfully.`,
                                life: 5000,
                            });
                            resolve(true);

                            isUpdateModalVisible.value = false;
                            updateForm.reset();
                            currentObjectiveId.value = null;
                            return true;
                        },
                        onError: (e) => {
                            toast.add({
                                severity: "error",
                                summary: "Error",
                                detail: `An error occured while trying to update the objective details.`,
                                life: 5000,
                            });
                            resolve(false);
                            return false;
                        },
                    }
                );
            },
            reject: () => {
                resolve(false);
            },
        });
    });
};
</script>

<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Objectives</Heading>
            <Button @click="openCreateModal" class="text-white">Create</Button>
        </DivFlexCenter>

        <TableContainer>
            <Table>
                <TableHead>
                    <TH>ID</TH>
                    <TH>Description</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="objective in objectives.data">
                        <TD>{{ objective.id }}</TD>
                        <TD>{{ objective.description }}</TD>
                        <TD>
                            <DivFlexCenter class="gap-1">
                                <EditButton
                                    @click="openUpdateModal(objective)"
                                />
                                <DeleteButton
                                    @click="
                                        deleteModel(
                                            route(
                                                'objectives.destroy',
                                                objective.id
                                            )
                                        )
                                    "
                                />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="objectives" />
        </TableContainer>
    </MainLayout>

    <!-- Create Modal -->
    <Dialog
        v-model:visible="isCreateModalVisible"
        header="Create New Objective"
        :style="{ width: '25rem' }"
    >
        <FormInput label="Description" :errorMessage="form.errors.description">
            <Textarea v-model="form.description" />
        </FormInput>

        <section class="flex justify-end mt-5">
            <Button @click="createModel" class="text-white">Create</Button>
        </section>
    </Dialog>

    <!-- Update Modal -->
    <Dialog
        v-model:visible="isUpdateModalVisible"
        header="Update Objective"
        :style="{ width: '25rem' }"
    >
        <FormInput
            label="Description"
            :errorMessage="updateForm.errors.description"
        >
            <Textarea v-model="updateForm.description" />
        </FormInput>

        <section class="flex justify-end mt-5">
            <Button @click="updateModel" class="text-white">Update</Button>
        </section>
    </Dialog>
</template>
