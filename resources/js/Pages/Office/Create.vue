<script setup>
import { useForm } from "@inertiajs/vue3";
import useStore from "@/Composables/useStore";
const form = useForm({
    name: null,
    office_code: null,
    remarks: null,
});

const { store } = useStore(form, route("offices.store"), "Office");
</script>

<template>
    <MainLayout>
        <Heading>Create New Office</Heading>
        <section class="rounded-lg grid grid-cols-2 gap-5 border-2 p-5">
            <InputContainer>
                <InputLabel label="Name" />
                <Input v-model="form.name" />
                <FormError>{{ form.errors.name }}</FormError>
            </InputContainer>
            <InputContainer>
                <InputLabel label="Office Code" />
                <Input v-model="form.office_code" />
                <FormError>{{ form.errors.office_code }}</FormError>
            </InputContainer>
            <InputContainer>
                <InputLabel label="Remarks" :isRequired="false" />
                <Textarea v-model="form.remarks" />
                <FormError>{{ form.errors.remarks }}</FormError>
            </InputContainer>
            <DivFlexCenter class="justify-end col-span-2">
                <Button class="text-white w-fit" @click="store">Create</Button>
            </DivFlexCenter>
        </section>
    </MainLayout>
</template>
