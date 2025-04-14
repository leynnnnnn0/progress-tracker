<script setup>
defineProps({
    offices: {
        type: Object,
        required: true,
    },
    targets: {
        type: Object,
        required: true,
    },
});

const exportToPdf = () => {
    window.open(route("target-accomplished-report"), "_blank");
};

const calculateAccomplishmentsTotal = (officesTarget) => {
    return officesTarget.reduce((total, item) => {
        const accomplishmentNumber =
            Number(item.actual_accomplishments_number) || 0;
        return total + accomplishmentNumber;
    }, 0);
};
</script>

<template>
    <MainLayout>
        <DivFlexCenter class="justify-between">
            <Heading>Target Accomplished</Heading>
            <Button
                @click="exportToPdf"
                class="text-white bg-slate-900 px-4 py-2 rounded-lg text-sm"
                >Export to PDF</Button
            >
        </DivFlexCenter>

        <DivFlexCol
            class="w-full h-auto rounded-lg border border-gray/20 space-y-5 overflow-auto overflow-x-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
        >
            <Table>
                <TableHead>
                    <TH>PROGRAMS, PROJECTS, ACTIVITIES</TH>
                    <TH>PERFORMANCE INDICATORS</TH>
                    <TH v-for="office in offices">
                        {{ office }}
                    </TH>
                    <TH>Total</TH>
                </TableHead>
                <TableBody v-for="target in targets">
                    <tr>
                        <TD
                            :rowspan="target.sub_targets.length + 1"
                            class="border-r border-gray-300"
                            >{{ target.description }}</TD
                        >
                    </tr>
                    <tr
                        v-for="sub_target in target.sub_targets"
                        class="divide-x divide-gray-300"
                    >
                        <TD>
                            {{ sub_target.description }}
                        </TD>
                        <TD v-for="target_number in sub_target.offices_target">
                            {{ target_number.actual_accomplishments_number }}
                        </TD>
                        <TD>{{
                            calculateAccomplishmentsTotal(
                                sub_target.offices_target
                            )
                        }}</TD>
                    </tr>
                </TableBody>
            </Table>
        </DivFlexCol>
    </MainLayout>
</template>
