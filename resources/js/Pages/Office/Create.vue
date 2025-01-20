<script setup>
import { useForm } from "@inertiajs/vue3";
import useAlert from "../../Composables/useAlert.js";
const { confirm, toast } = useAlert();
const form = useForm({
    name: null,
    remarks: null,
});

const store = () => {
    confirm.require({
        message: "Are you sure you want to create this office?",
        header: "Confirmation",
        icon: "pi pi-exclamation-triangle",
        rejectProps: {
            label: "Cancel",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Confirm",
            severity: "success",
        },
        accept: () => {},
    });
};
</script>

<template>
    <MainLayout>
        <Heading>Create New Office</Heading>
        <section class="rounded-lg grid grid-cols-2 gap-5 border-2 p-5">
            <InputContainer>
                <InputLabel label="Name" />
                <Input />
            </InputContainer>
            <InputContainer>
                <InputLabel label="Remarks" :isRequired="false" />
                <Textarea />
            </InputContainer>
            <DivFlexCenter class="justify-end col-span-2">
                <Button class="text-white w-fit" @click="store">Create</Button>
            </DivFlexCenter>
        </section>
    </MainLayout>
</template>
