<script setup>
import { useForm } from "@inertiajs/vue3";
import Select from "primevue/select";
import useStore from "@/Composables/useStore";
import { ref } from "vue";
const { positions } = defineProps({
    positions: {
        type: Object,
        required: true,
    },
});
const form = useForm({
    first_name: null,
    middle_name: null,
    last_name: null,
    position: null,
});

const positionsOptions = ref(
    Object.entries(positions).map(([value, label]) => ({
        label,
        value,
    }))
);

const { store } = useStore(form, route("employees.store"), "Employee");
</script>

<template>
    <MainLayout>
        <Heading>Create Employeee</Heading>

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
                <Select
                    v-model="form.position"
                    :options="positionsOptions"
                    optionLabel="label"
                    optionValue="value"
                    placeholder="Select a Position"
                    class="w-full"
                    filter
                />
            </FormInput>

            <FormFooter>
                <Button class="text-white w-fit" @click="store">Create</Button>
            </FormFooter>
        </FormContainer>
    </MainLayout>
</template>
