<script setup>
import { useForm } from "@inertiajs/vue3";
import useStore from "@/Composables/useStore";

const form = useForm({
    first_name: null,
    middle_name: null,
    last_name: null,
    phone_number: null,
    email: null,
    password: null,
});

const { store } = useStore(form, route("users.store"), "User");
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
            <FormInput
                label="Phone Number"
                :errorMessage="form.errors.phone_number"
            >
                <Input v-model="form.phone_number" type="number" />
            </FormInput>
            <FormInput label="Email" :errorMessage="form.errors.email">
                <Input v-model="form.email" type="email" />
            </FormInput>

            <FormFooter>
                <Button class="text-white" @click="store">Create</Button>
            </FormFooter>
        </FormContainer>
    </MainLayout>
</template>
