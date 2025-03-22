<script setup>
import { useForm } from "@inertiajs/vue3";
import useUpdate from "@/Composables/useUpdate";
import Select from "primevue/select";

const { user, offices } = defineProps({
    user: {
        type: Object,
        required: true,
    },
    offices: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    first_name: user.first_name,
    middle_name: user.middle_name,
    last_name: user.last_name,
    phone_number: user.phone_number,
    email: user.email,
    is_admin: user.is_admin,
    is_active: user.is_active,
    assignedOffices: user.offices_array,
});

const roles = [
    { value: 1, label: "Admin" },
    { value: 0, label: "User" },
];

const statuses = [
    { value: 1, label: "Yes" },
    { value: 0, label: "No" },
];

console.log(form.assignedOffices);

const { update } = useUpdate(form, route("users.update", user.id), "User");
</script>

<template>
    <MainLayout>
        <Heading>Update User Details</Heading>
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
            <FormInput
                label="Phone Number"
                :errorMessage="form.errors.phone_number"
            >
                <Input v-model="form.phone_number" type="number" />
            </FormInput>
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

            <FormInput
                label="Is Account Active?"
                :errorMessage="form.errors.is_active"
            >
                <Select
                    v-model="form.is_active"
                    :options="statuses"
                    optionLabel="label"
                    optionValue="value"
                    placeholder="Select"
                    class="w-full"
                />
            </FormInput>

            <InputContainer class="col-span-2 gap-2">
                <InputLabel label="Assigned Offices" />

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
                <Button class="text-white" @click="update">Update</Button>
            </FormFooter>
        </FormContainer>
    </MainLayout>
</template>
