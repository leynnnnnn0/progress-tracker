<script setup>
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import Dialog from "primevue/dialog";
import useStore from "@/Composables/useStore";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";


const form = useForm({
    description: null,
    percentage_group: null,
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

const deleteSubTarget = (id) => {
    form.sub_targets = form.sub_targets.filter((item) => item.id != id);
};

const isSubTaskEditModalOpen = ref(false);
const subTargetId = ref(null);
const editSubTarget = (id) => {
    subTargetId.value = id;
    isSubTaskEditModalOpen.value = true;
    const target = form.sub_targets.find((item) => item.id == id);
    subTarget.value = target.description;
};

const updateSubTarget = () => {
    const index = form.sub_targets.findIndex(
        (item) => item.id == subTargetId.value
    );
    form.sub_targets[index].description = subTarget.value;
    isSubTaskEditModalOpen.value = false;
    subTarget.value = "";
};

const { store } = useStore(form, route("targets.store"), "Target");
</script>

<template>
    <MainLayout>
        <Heading>Create New Target</Heading>
        <FormContainer>
            <FormInput
                label="Description"
                :errorMessage="form.errors.description"
            >
                <Textarea v-model="form.description" />
            </FormInput>
            <FormInput
                label="Percentage Group"
                :errorMessage="form.errors.percentage_group"
            >
                <Select v-model="form.percentage_group">
                    <SelectTrigger>
                        <SelectValue placeholder="Select a fruit" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Fruits</SelectLabel>
                            <SelectItem value="75"> 75 </SelectItem>
                            <SelectItem value="15"> 15 </SelectItem>
                            <SelectItem value="10"> 10 </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
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
                                <EditButton @click="editSubTarget(target.id)" />
                                <DeleteButton
                                    @click="deleteSubTarget(target.id)"
                                />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
        </TableContainer>
        <DivFlexCenter class="justify-end">
            <Button @click="store" class="text-white">Create</Button>
        </DivFlexCenter>

        <Dialog
            v-model:visible="isSubTaskModalOpen"
            modal
            :style="{ width: '30rem' }"
        >
            <template #header>Sub-Target</template>
            <DivFlexCol>
                <FormInput label="Description">
                    <Textarea v-model="subTarget" />
                </FormInput>
            </DivFlexCol>
            <DivFlexCenter class="justify-end">
                <Button @click="addToSubTasks" class="text-white">Add</Button>
            </DivFlexCenter>
        </Dialog>

        <Dialog
            v-model:visible="isSubTaskEditModalOpen"
            modal
            :style="{ width: '30rem' }"
        >
            <template #header>Sub-Target</template>
            <DivFlexCol>
                <FormInput label="Description">
                    <Textarea v-model="subTarget" />
                </FormInput>
            </DivFlexCol>
            <DivFlexCenter class="justify-end">
                <Button @click="updateSubTarget" class="text-white"
                    >Update</Button
                >
            </DivFlexCenter>
        </Dialog>
    </MainLayout>
</template>
