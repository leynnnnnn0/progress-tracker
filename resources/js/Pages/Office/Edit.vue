<script setup>
import { useForm } from "@inertiajs/vue3";
import useAlert from "../../Composables/useAlert.js";
const { confirm, toast } = useAlert();

const { office } = defineProps({
    office: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    name: office.name,
    remarks: office.remarks,
});

const update = () => {
    confirm.require({
        message: "Are you sure you want to update this office details?",
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
        accept: () => {
            form.put(route("offices.update", office.id), {
                onSuccess: () => {
                    toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Office Details Updated Successfully.",
                        life: 5000,
                    });
                },
                onError: () => {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "An error occured while trying to update the office.",
                        life: 5000,
                    });
                },
            });
        },
    });
};
</script>

<template>
    <MainLayout>
        <Heading>Edit Office Details</Heading>
        <section class="rounded-lg grid grid-cols-2 gap-5 border-2 p-5">
            <InputContainer>
                <InputLabel label="Name" />
                <Input v-model="form.name" />
                <FormError>{{ form.errors.name }}</FormError>
            </InputContainer>
            <InputContainer>
                <InputLabel label="Remarks" :isRequired="false" />
                <Textarea v-model="form.remarks" />
                <FormError>{{ form.errors.remarks }}</FormError>
            </InputContainer>
            <DivFlexCenter class="justify-end col-span-2">
                <Button class="text-white w-fit" @click="update">Update</Button>
            </DivFlexCenter>
        </section>
    </MainLayout>
</template>
