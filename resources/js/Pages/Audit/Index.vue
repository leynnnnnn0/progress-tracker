<script setup>
defineProps({
    audits: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <Heading>Audits</Heading>
        <TableContainer>
            <Table>
                <TableHead>
                    <TH>ID</TH>
                    <TH>User</TH>
                    <TH>Event</TH>
                    <TH>Model</TH>
                    <TH>Date and Time</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="audit in audits.data">
                        <TD>{{ audit.id }}</TD>
                        <TD>{{
                            audit.user.first_name + " " + audit.user.last_name
                        }}</TD>
                        <TD>{{ audit.event.toUpperCase() }}</TD>
                        <TD>{{ audit.auditable_type }}</TD>
                        <TD>{{ audit.dateAndTime }}</TD>
                        <TD>
                            <ShowButton />
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="audits" />
        </TableContainer>
    </MainLayout>
</template>
