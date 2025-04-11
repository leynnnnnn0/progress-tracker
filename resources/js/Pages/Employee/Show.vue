<script setup>
const { employee } = defineProps({
    employee: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <Heading>Employeee Details</Heading>
        <FormContainer>
            <Infolist label="First Name" :value="employee.first_name" />
            <Infolist label="Middle Name" :value="employee.middle_name" />
            <Infolist label="Last Name" :value="employee.last_name" />
            <Infolist label="Position" :value="employee.position" />
        </FormContainer>
    </MainLayout>
</template>
