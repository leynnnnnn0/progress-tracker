<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Select from "primevue/select";
import useUpdate from "@/Composables/useUpdate";
const { positions, employee } = defineProps({
    positions: {
        type: Object,
        required: true,
    },
    employee: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    first_name: employee.first_name,
    middle_name: employee.middle_name,
    last_name: employee.last_name,
    position: employee.position,
});

const positionsOptions = ref(
    Object.entries(positions).map(([value, label]) => ({
        label,
        value,
    }))
);

const { update } = useUpdate(
    form,
    route("employees.update", employee.id),
    "Employee"
);

console.log(positionsOptions);
</script>

<template>
    <MainLayout>
        <Heading>Edit Employeee Details</Heading>

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
            <FormInput label="Position" :errorMessage="form.errors.position">
                <Input v-model="form.position" />
            </FormInput>

            <FormFooter>
                <Button class="text-white w-fit" @click="update">Create</Button>
            </FormFooter>
        </FormContainer>
    </MainLayout>
</template>
