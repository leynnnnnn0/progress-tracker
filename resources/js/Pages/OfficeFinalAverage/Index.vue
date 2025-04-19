<script setup>
import Pagination from "@/Components/table/Pagination.vue";
import { useSearch } from "@/Composables/useSearch";
const { offices } = defineProps({
    offices: {
        type: Object,
        required: true,
    },
});
const { search } = useSearch("offices-final-average.index");
</script>

<template>
    <MainLayout>
        <Heading>Offices Final Average</Heading>
        <TableContainer>
            <TableHeader>
                <SearchBar>
                    <Input
                        class="pl-10"
                        placeholder="Search..."
                        v-model="search"
                    />
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
                        <TD>{{ office.final_average }}</TD>
                    </tr>
                </TableBody>
            </Table>

            <Pagination :data="offices" />
        </TableContainer>
    </MainLayout>
</template>
