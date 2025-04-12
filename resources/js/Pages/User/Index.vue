<script setup>
import { useSearch } from "@/Composables/useSearch";
import useDelete from "@/Composables/useDelete.js";
const { users } = defineProps({
    users: {
        type: Object,
        required: true,
    },
});
const { search } = useSearch("users.index");
const { deleteModel } = useDelete("User");
</script>
<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Users</Heading>
            <Link
                :href="route('users.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New User</Link
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
                    <TH>Email</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="user in users.data">
                        <TD>{{ user.id }}</TD>
                        <TD>{{ user.full_name }}</TD>
                        <TD>{{ user.email }}</TD>
                        <TD class="flex flex-center gap-3">
                            <ShowButton
                                :isLink="true"
                                :href="route('users.show', user.id)"
                            />
                            <EditButton
                                :isLink="true"
                                :href="route('users.edit', user.id)"
                            />
                            <!-- <DeleteButton
                                @click="
                                    deleteModel(route('users.destroy', user.id))
                                "
                            /> -->
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="users" />
        </TableContainer>
    </MainLayout>
</template>
