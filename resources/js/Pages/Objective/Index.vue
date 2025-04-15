<script setup>
defineProps({
    objectives: {
        type: Object,
        required: true,
    },
});

import Textarea from "@/Components/ui/textarea/Textarea.vue";
import useStore from "@/Composables/useStore";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
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
                        <TD></TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="objectives" />
        </TableContainer>
    </MainLayout>

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
</template>
