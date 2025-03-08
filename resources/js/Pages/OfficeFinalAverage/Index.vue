<script setup>
import Pagination from "@/Components/table/Pagination.vue";

const { offices, targets } = defineProps({
    offices: {
        type: Object,
        required: true,
    },
    targets: {
        type: Object,
        required: true,
    },
});

console.log(targets);
</script>

<template>
    <MainLayout>
        <Heading>Offices Final Average</Heading>
        <TableContainer>
            <TableHeader>
                <SearchBar>
                    <Input class="pl-10" placeholder="Search..." />
                </SearchBar>
            </TableHeader>
            <Table>
                <TableHead>
                    <TH>ID</TH>
                    <TH>Office</TH>
                    <TH>Office Code</TH>
                    <TH> Final Average </TH>
                </TableHead>
                <TableBody>
                    <tr v-for="office in offices.data">
                        <TD>{{ office.id }}</TD>
                        <TD>{{ office.name }}</TD>
                        <TD>{{ office.office_code }}</TD>
                        <TD>TBD</TD>
                    </tr>
                </TableBody>
            </Table>

            <Pagination :data="offices" />
        </TableContainer>
    </MainLayout>
</template>
