<script setup>
import { useForm } from "@inertiajs/vue3";
import useStore from "@/Composables/useStore";
import Select from "primevue/select";
import { ref } from "vue";

const { offices } = defineProps({
    offices: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    first_name: null,
    middle_name: null,
    last_name: null,
    email: null,
    is_admin: null,
    password: null,
    assignedOffices: [],
});

const roles = [
    { value: 1, label: "Admin" },
    { value: 0, label: "User" },
];
const { store } = useStore(form, route("users.store"), "User");

const isAllSelected = ref(form.assignedOffices.length == offices.length);

const selectAll = () => {
    form.assignedOffices = offices.map((office) => office.value);
    isAllSelected.value = true;
};

const deselectALl = () => {
    form.assignedOffices = [];
    isAllSelected.value = false;
};
</script>

<template>
    <MainLayout>
        <Heading>Create New User</Heading>
        <FormContainer>
            <FormInput
                label="First Name"
                :errorMessage="form.errors.first_name"
            >
                <Input v-model="form.first_name" />
            </FormInput>
            <FormInput
                label="Middle Name"
                :errorMessage="form.errors.middle_name"
                :isRequired="false"
            >
                <Input v-model="form.middle_name" />
            </FormInput>
            <FormInput label="Last Name" :errorMessage="form.errors.last_name">
                <Input v-model="form.last_name" />
            </FormInput>
            <!-- <FormInput
                label="Office Phone Number"
                :errorMessage="form.errors.phone_number"
            >
                <Input
                    type="tel"
                    v-model="form.phone_number"
                    minlength="11"
                    maxlength="11"
                    onkeydown="return !(event.keyCode === 69 || event.keyCode === 187 || event.keyCode === 189)"
                />
            </FormInput> -->
            <FormInput label="Email" :errorMessage="form.errors.email">
                <Input v-model="form.email" type="email" />
            </FormInput>

            <FormInput label="Role" :errorMessage="form.errors.is_admin">
                <Select
                    v-model="form.is_admin"
                    :options="roles"
                    optionLabel="label"
                    optionValue="value"
                    placeholder="Select a Role"
                    class="w-full"
                />
            </FormInput>

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

            <FormFooter>
                <Button class="text-white" @click="store">Create</Button>
            </FormFooter>
        </FormContainer>
    </MainLayout>
</template>
