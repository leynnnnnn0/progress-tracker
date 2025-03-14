<script setup>
import { useSearch } from "@/Composables/useSearch.js";
import useDelete from "@/Composables/useDelete.js";
defineProps({
    targets: {
        type: Object,
        required: true,
    },
});
const { search } = useSearch("targets.index");
const { deleteModel } = useDelete("Target");
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
                                <ShowButton
                                    :isLink="true"
                                    :href="route('targets.show', target.id)"
                                />
                                <EditButton
                                    :isLink="true"
                                    :href="route('targets.edit', target.id)"
                                />
                                <DeleteButton
                                    @click="
                                        deleteModel(
                                            route('targets.destroy', target.id)
                                        )
                                    "
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
