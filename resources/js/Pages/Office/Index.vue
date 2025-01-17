<script setup>
const { offices } = defineProps({
    offices: {
        type: Object,
        required: true,
    },
});

console.log(offices);
</script>
<template>
    <MainLayout>
        <h1 class="font-bold text-2xl">Offices</h1>
        <TableContainer>
            <Table>
                <TableHead>
                    <TH>Id</TH>
                    <TH>Name</TH>
                    <TH>Remarks</TH>
                    <TH>Action</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="office in offices.data">
                        <TD>{{ office.id }}</TD>
                        <TD>{{ office.name }}</TD>
                        <TD>{{ office.remarks ?? "N/a" }}</TD>
                        <TD class="flex flex-center gap-3">
                            <ShowButton />
                            <EditButton />
                            <DeleteButton />
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="offices" />
        </TableContainer>
    </MainLayout>
</template>
