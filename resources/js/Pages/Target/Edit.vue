<script setup>
import Dialog from "primevue/dialog";
import useUpdate from "@/Composables/useUpdate";
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const { target, offices, objectives } = defineProps({
    target: {
        type: Object,
        required: true,
    },
    offices: {
        type: Array,
        required: true,
    },
    objectives: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    description: target.description,
    sub_targets: [],
    group: target.group,
    assignedOffices: target.offices_array,
    objective_id: target.sub_targets[0].objective_id,
});

const isAllSelected = ref(form.assignedOffices.length == offices.length);

const selectAll = () => {
    form.assignedOffices = offices.map((office) => office.value);
    isAllSelected.value = true;
};

const deselectALl = () => {
    form.assignedOffices = [];
    isAllSelected.value = false;
};

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

            <FormInput
                class="col-span-2"
                label="Percentage Group"
                :errorMessage="form.errors.group"
            >
                <Select v-model="form.group">
                    <SelectTrigger>
                        <SelectValue placeholder="Select from options" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Options</SelectLabel>
                            <SelectItem value="core"> Core </SelectItem>
                            <SelectItem value="strategic">
                                Strategic
                            </SelectItem>
                            <SelectItem value="support"> Support </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
            </FormInput>

            <FormInput
                v-if="form.group == 'core'"
                class="col-span-2"
                label="Objective"
                :errorMessage="form.errors.objective_id"
            >
                <Select v-model="form.objective_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Select from options" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectLabel>Options</SelectLabel>

                            <SelectItem
                                v-for="objective in objectives"
                                :value="objective.value"
                            >
                                {{ objective.label }}
                            </SelectItem>
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

        <TableContainer>
            <InputContainer class="col-span-2 gap-2">
                <DivFlexCenter class="justify-between">
                    <InputLabel label="Assigned Offices" />
                    <Button
                        v-if="!isAllSelected"
                        class="text-white"
                        @click="selectAll"
                        >Select All</Button
                    >
                    <Button
                        v-if="isAllSelected"
                        class="text-white"
                        @click="deselectALl"
                        >Deselect All</Button
                    >
                </DivFlexCenter>

                <div
                    class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                >
                    <div
                        v-for="office in offices"
                        :key="office.value"
                        class="flex items-center space-x-2"
                    >
                        <Checkbox
                            v-model="form.assignedOffices"
                            :value="office.value"
                            name="assignedOffices[]"
                        />
                        <label class="text-xs text-gray-600">
                            {{ office.label }}
                        </label>
                    </div>
                </div>
                <FormError>{{ form.errors.assignedOffices }}</FormError>
            </InputContainer>
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
