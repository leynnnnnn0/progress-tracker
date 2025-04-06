<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import useUpdate from "@/Composables/useUpdate";
import useAlert from "@/Composables/useAlert.js";
const { confirm, toast } = useAlert();
const user = usePage().props.auth.user;
const form = useForm({
    first_name: user.first_name,
    middle: user.middle_name,
    last_name: user.last_name,
    email: user.email,
});

const passwordForm = useForm({
    password: null,
    confirm_password: null,
});

const updatePassword = () => {
    passwordForm.put(route("profiles.update-password", user.id), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: `Password Updated Successfully.`,
                life: 5000,
            });
        },
        onError: (e) => {
            toast.add({
                severity: "error",
                summary: "Error",
                detail: `An error occured while trying to update the password details.`,
                life: 5000,
            });
        },
    });
};

const { update } = useUpdate(
    form,
    route("profiles.update-information", user.id),
    "User Details"
);
</script>

<template>
    <MainLayout>
        <Heading>Update User Information</Heading>
        <TableContainer>
            <FormInput
                label="First Name"
                :errorMessage="form.errors.first_name"
            >
                <Input v-model="form.first_name" />
            </FormInput>
            <FormInput
                label="Middle Name"
                :isRequired="false"
                :errorMessage="form.errors.middle_name"
            >
                <Input v-model="form.middle_name" />
            </FormInput>
            <FormInput label="Last Name" :errorMessage="form.errors.last_name">
                <Input v-model="form.last_name" />
            </FormInput>
            <FormInput label="Email" :errorMessage="form.errors.email">
                <Input v-model="form.email" type="email" />
            </FormInput>
            <section class="flex justify-end">
                <Button @click="update" class="text-white">Update</Button>
            </section>
        </TableContainer>

        <TableContainer>
            <FormInput
                label="Password"
                :errorMessage="passwordForm.errors.password"
            >
                <Input v-model="passwordForm.password" type="password" />
            </FormInput>
            <FormInput
                label="Confirm Password"
                :errorMessage="passwordForm.errors.confirm_password"
            >
                <Input
                    v-model="passwordForm.confirm_password"
                    type="password"
                />
            </FormInput>
            <section class="flex justify-end">
                <Button class="text-white" @click="updatePassword"
                    >Update</Button
                >
            </section>
        </TableContainer>
    </MainLayout>
</template>
