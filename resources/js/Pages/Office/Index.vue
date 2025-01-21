<script setup>
import { router } from "@inertiajs/vue3";
import useAlert from "../../Composables/useAlert.js";
const { confirm, toast } = useAlert();
const { offices } = defineProps({
    offices: {
        type: Object,
        required: true,
    },
});

const deleteModel = (route) => {
    confirm.require({
        message: "Are you sure you want to delete this office?",
        header: "Confirmation",
        icon: "pi pi-exclamation-triangle",
        rejectProps: {
            label: "Cancel",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "Confirm",
            severity: "danger",
        },
        accept: () => {
            router.delete(route, {
                onSuccess: () => {
                    toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Office Deleted Successfully.",
                        life: 5000,
                    });
                },
                onError: () => {
                    toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "An error occured while trying to delete this office.",
                        life: 5000,
                    });
                },
            });
        },
    });
};
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
