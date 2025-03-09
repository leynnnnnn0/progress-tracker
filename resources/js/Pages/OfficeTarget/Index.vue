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
</script>

<template>
    <MainLayout>
        <Heading>Offices Target</Heading>

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
                        <TD v-for="office in offices"> </TD>
                    </tr>
                </TableBody>
            </Table>
        </DivFlexCol>
    </MainLayout>
</template>
