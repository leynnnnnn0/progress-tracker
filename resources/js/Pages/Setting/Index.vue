<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import useUpdate from "@/Composables/useUpdate";
import useAlert from "@/Composables/useAlert.js";
const { confirm, toast } = useAlert();
const user = usePage().props.auth.user;

const passwordForm = useForm({
    password: null,
    confirm_password: null,
});

const updatePassword = () => {
    passwordForm.put(route("settings.update", user.id), {
        onSuccess: () => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: `Password Updated Successfully.`,
                life: 5000,
            });
            passwordForm.reset();
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
</script>

<template>
    <MainLayout>
        <Heading>Update Password</Heading>
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
