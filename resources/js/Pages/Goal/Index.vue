<script setup>
const { goals } = defineProps({
    goals: {
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
const { deleteModel } = useDelete("Goal");
// Create modal controls
const isCreateModalVisible = ref(false);

const openCreateModal = () => {
    isCreateModalVisible.value = true;
};

const form = useForm({
    description: null,
});

const { store } = useStore(form, route("goals.store"), "Goal");

const createModel = async () => {
    const result = await store();
    if (result) {
        isCreateModalVisible.value = false;
        form.reset();
    }
};

// Update modal controls
const isUpdateModalVisible = ref(false);
const currentgoalId = ref(null);

const updateForm = useForm({
    description: null,
});

const openUpdateModal = (goal) => {
    currentgoalId.value = goal.id;
    updateForm.description = goal.description;
    isUpdateModalVisible.value = true;
    console.log(currentgoalId.value);
};

const updateModel = async () => {
    new Promise((resolve) => {
        confirm.require({
            message: `Are you sure you want to update this goal?`,
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
                updateForm.put(route("goals.update", currentgoalId.value), {
                    onSuccess: () => {
                        toast.add({
                            severity: "success",
                            summary: "Success",
                            detail: `Goal Updated Successfully.`,
                            life: 5000,
                        });
                        resolve(true);

                        isUpdateModalVisible.value = false;
                        updateForm.reset();
                        currentgoalId.value = null;
                        return true;
                    },
                    onError: (e) => {
                        toast.add({
                            severity: "error",
                            summary: "Error",
                            detail: `An error occured while trying to update the goal details.`,
                            life: 5000,
                        });
                        resolve(false);
                        return false;
                    },
                });
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
            <Heading>Goals</Heading>
            <Link
                :href="route('goals.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New Goal</Link
            >
        </DivFlexCenter>

        <TableContainer>
            <Table>
                <TableHead>
                    <TH>ID</TH>
                    <TH>Description</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="goal in goals.data">
                        <TD>{{ goal.id }}</TD>
                        <TD>{{ goal.description }}</TD>
                        <TD>
                            <DivFlexCenter class="gap-1">
                                <ShowButton
                                    :isLink="true"
                                    :href="route('goals.show', goal.id)"
                                />
                                <EditButton
                                    :isLink="true"
                                    :href="route('goals.edit', goal.id)"
                                />
                                <DeleteButton
                                    @click="
                                        deleteModel(
                                            route('goals.destroy', goal.id)
                                        )
                                    "
                                />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="goals" />
        </TableContainer>
    </MainLayout>

    <!-- Create Modal -->
    <Dialog
        v-model:visible="isCreateModalVisible"
        header="Create New Goal"
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
        header="Update goal"
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
