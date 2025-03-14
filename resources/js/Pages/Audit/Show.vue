<script setup>
defineProps({
    audit: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <MainLayout>
        <Heading>Audit Details</Heading>
        <FormContainer>
            <Infolist label="ID" :value="audit.id" />
            <Infolist
                label="User"
                :value="audit.user.first_name + ' ' + audit.user.last_name"
            />
            <Infolist label="Event" :value="audit.event.toUpperCase()" />
            <Infolist label="Model" :value="audit.auditable_type" />
            <Infolist label="Date and Time" :value="audit.dateAndTime" />
        </FormContainer>

        <FormContainer>
            <SpanXS class="col-span-2">Old Values</SpanXS>
            <SpanBold v-if="audit.old_values?.length < 1 || !audit.old_values"
                >None</SpanBold
            >
            <Infolist
                v-if="audit.old_values"
                v-for="(value, key) in audit.old_values"
                :label="key"
                :value="value ?? 'None'"
            ></Infolist>
        </FormContainer>

        <FormContainer>
            <SpanXS class="col-span-2">New Values</SpanXS>
            <SpanBold v-if="audit.new_values?.length < 1 || !audit.new_values"
                >None</SpanBold
            >
            <Infolist
                v-if="audit.new_values"
                v-for="(value, key) in audit.new_values"
                :label="key"
                :value="value ?? 'None'"
            ></Infolist>
        </FormContainer>

        <BackButton />
    </MainLayout>
</template>
