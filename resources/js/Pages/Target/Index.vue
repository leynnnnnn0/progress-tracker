<script setup>
defineProps({
    targets: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Targets</Heading>
            <Link
                :href="route('targets.create')"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Create New Target</Link
            >
        </DivFlexCenter>

        <TableContainer>
            <Table>
                <TableHead>
                    <TH>ID</TH>
                    <TH>Description</TH>
                    <TH>Actions</TH>
                </TableHead>
                <TableBody>
                    <tr v-for="target in targets.data">
                        <TD>{{ target.id }}</TD>
                        <TD>{{ target.description }}</TD>
                        <TD>
                            <DivFlexCenter class="gap-2">
                                <EditButton
                                    :isLink="true"
                                    :href="route('targets.edit', target.id)"
                                />
                            </DivFlexCenter>
                        </TD>
                    </tr>
                </TableBody>
            </Table>
            <Pagination :data="targets" />
        </TableContainer>
    </MainLayout>
</template>
