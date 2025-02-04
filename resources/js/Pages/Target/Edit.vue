<script setup>
import Dialog from "primevue/dialog";
import useUpdate from "@/Composables/useUpdate";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const { target } = defineProps({
    target: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    description: target.description,
    sub_targets: [],
});

const isSubTaskModalOpen = ref(false);
const openSubTaskModal = () => {
    isSubTaskModalOpen.value = true;
};
const subTarget = ref("");

const addToSubTasks = () => {
    const uid =
        Date.now().toString(36) + Math.random().toString(36).substr(2, 9);
    form.sub_targets.push({
        id: uid,
        description: subTarget.value,
    });
    isSubTaskModalOpen.value = false;
    subTarget.value = null;
};

target.sub_targets.map((item) => {
    form.sub_targets.push({
        id: item.id,
        description: item.description,
    });
});

const { update } = useUpdate(
    form,
    route("targets.update", target.id),
    "Target"
);
</script>

<template>
    <MainLayout>
        <Heading>Edit Target Details</Heading>
        <FormContainer>
            <FormInput label="Description" class="col-span-2">
                <Input v-model="form.description" />
            </FormInput>
        </FormContainer>
        <TableContainer>
            <TableHeader>
                <Button @click="openSubTaskModal" class="text-white"
                    >Add Sub-Target</Button
                >
            </TableHeader>
            <Table>
                <TableHead>
                    <TH>Description</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="target in form.sub_targets">
                        <TD>{{ target.description }}</TD>
                        <TD>
                            <DivFlexCenter class="gap-2">
                                <EditButton />
                                <DeleteButton />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
        </TableContainer>
        <DivFlexCenter class="justify-end">
            <Button @click="update" class="text-white">Update</Button>
        </DivFlexCenter>

        <Dialog
            v-model:visible="isSubTaskModalOpen"
            modal
            :style="{ width: '30rem' }"
        >
            <template #header>Sub-Target</template>
            <DivFlexCol>
                <FormInput label="Description">
                    <Input v-model="subTarget" />
                </FormInput>
            </DivFlexCol>
            <DivFlexCenter class="justify-end">
                <Button @click="addToSubTasks" class="text-white">Add</Button>
            </DivFlexCenter>
        </Dialog>
    </MainLayout>
</template>
