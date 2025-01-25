<script setup>
import useDelete from "@/Composables/useDelete.js";

const { offices } = defineProps({
    offices: {
        type: Object,
        required: true,
    },
});

const { deleteModel } = useDelete("Office");
</script>
<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Offices</Heading>
            <Link
                :href="route('offices.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New Office</Link
            >
        </DivFlexCenter>
        <TableContainer>
            <Table>
                <TableHead>
                    <TH>Id</TH>
                    <TH>Name</TH>
                    <TH>Code</TH>
                    <TH>Action</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="office in offices.data">
                        <TD>{{ office.id }}</TD>
                        <TD>{{ office.name }}</TD>
                        <TD>{{ office.office_code }}</TD>
                        <TD class="flex flex-center gap-3">
                            <ShowButton />
                            <EditButton
                                :isLink="true"
                                :href="route('offices.edit', office.id)"
                            />
                            <DeleteButton
                                @click="
                                    deleteModel(
                                        route('offices.destroy', office.id)
                                    )
                                "
                            />
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="offices" />
        </TableContainer>
    </MainLayout>
</template>
