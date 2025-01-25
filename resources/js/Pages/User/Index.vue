<script setup>
import useDelete from "@/Composables/useDelete.js";
const { users } = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

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
            <Table>
                <TableHead>
                    <TH>Id</TH>
                    <TH>Full Name</TH>
                    <TH>Email</TH>
                    <TH>Phone Number</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="user in users.data">
                        <TD>{{ user.id }}</TD>
                        <TD>{{ user.full_name }}</TD>
                        <TD>{{ user.email }}</TD>
                        <TD>{{ user.phone_number ?? "N/a" }}</TD>
                        <TD class="flex flex-center gap-3">
                            <ShowButton />
                            <EditButton
                                :isLink="true"
                                :href="route('users.edit', user.id)"
                            />
                            <DeleteButton
                                @click="
                                    deleteModel(route('users.destroy', user.id))
                                "
                            />
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="users" />
        </TableContainer>
    </MainLayout>
</template>
