<script setup>
const { user } = defineProps({
    user: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <Heading>User Details</Heading>
        <FormContainer>
            <Infolist label="First Name" :value="user.first_name" />
            <Infolist label="Middle Name" :value="user.middle_name" />
            <Infolist label="Last Name" :value="user.last_name" />
            <Infolist label="Phone Number" :value="user.phone_number" />
            <Infolist label="Email" :value="user.email" />
        </FormContainer>
        <BackButton />
    </MainLayout>
</template>
