<script setup>
import { useSearch } from "@/Composables/useSearch";
const { search } = useSearch("employees.index");

const { employees } = defineProps({
    employees: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Employees</Heading>
            <Link
                :href="route('employees.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New Employee</Link
            >
        </DivFlexCenter>

        <TableContainer class="p-5">
            <TableHeader>
                <SearchBar>
                    <Input
                        v-model="search"
                        class="pl-10"
                        placeholder="Search..."
                    />
                </SearchBar>
            </TableHeader>

            <Table>
                <TableHead>
                    <TH>Id</TH>
                    <TH>Full Name</TH>
                    <TH>Position</TH>
                    <TH>Actions</TH>
                </TableHead>

                <TableBody>
                    <tr v-for="employee in employees.data">
                        <TD>{{ employee.id }}</TD>
                        <TD>{{ employee.full_name }}</TD>
                        <TD>{{ employee.position }}</TD>
                        <TD class="flex flex-center gap-3">
                            <ShowButton
                                :isLink="true"
                                :href="route('employees.show', employee.id)"
                            />
                            <EditButton
                                :isLink="true"
                                :href="route('employees.edit', employee.id)"
                            />
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="employees" />
        </TableContainer>
    </MainLayout>
</template>
