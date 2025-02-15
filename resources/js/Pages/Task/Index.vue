<script setup>
import { router } from "@inertiajs/vue3";
import { watch, ref } from "vue";

const { targets, offices, filters } = defineProps({
    targets: {
        type: Object,
        required: true,
    },
    offices: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
});
const office = ref(filters.office ?? offices[0].value.toString());
watch(office, (value) => {
    router.get(route("tasks.index"), {
        office: value,
    });
});
</script>
<template>
    <MainLayout>
        <Select v-model="office">
            <SelectTrigger>
                <SelectValue placeholder="Select an office" />
            </SelectTrigger>
            <SelectContent>
                <SelectGroup>
                    <SelectLabel>Offices</SelectLabel>
                    <SelectItem
                        v-for="office in offices"
                        :value="office.value.toString()"
                    >
                        {{ office.label }}
                    </SelectItem>
                </SelectGroup>
            </SelectContent>
        </Select>

        <DivFlexCol class="gap-5">
            <DivFlexCol class="items-center justify-center gap-3">
                <H1Bold> DEPARTMENT PERFORMANCE COMMITMENT AND REVIEW </H1Bold>
                <SpanXS
                    >I, FULL NAME HERE, POSITION and OFFICIAL DESIGNATION of the
                    OFFICE NAME, commit to deliver and agree to be rated on the
                    attainment of following targets in accordance with the
                    indicated measure for the period (January - June
                    2025)</SpanXS
                >
            </DivFlexCol>

            <DivFlexCenter class="justify-between">
                <DivFlexCol class="w-full gap-1">
                    <Label>Approved By</Label>
                    <SpanXS>Name: </SpanXS>
                    <SpanXS>Position: </SpanXS>
                    <SpanXS>Date: </SpanXS>
                </DivFlexCol>
                <DivFlexCol class="w-full">
                    <SpanXS>Name of Employee:</SpanXS>
                    <SpanXS>Date:</SpanXS>

                    <DivFlexCol class="mt-3 gap-1">
                        <Label>Rating Scale:</Label>
                        <SpanXS>5 - Outstanding</SpanXS>
                        <SpanXS>4 - Very Satisfactory</SpanXS>
                        <SpanXS>3 - Satisfactory</SpanXS>
                        <SpanXS>2 - Unsatisfactory</SpanXS>
                        <SpanXS>1 - Poor</SpanXS>
                    </DivFlexCol>
                </DivFlexCol>
            </DivFlexCenter>

            <DivFlexCol
                class="w-full h-auto rounded-lg border border-gray/20 space-y-5 overflow-auto overflow-x-auto scrollbar-thin scrollbar-track-gray-100 scrollbar-thumb-gray-300 hover:scrollbar-thumb-gray-400"
            >
                <Table>
                    <TableHead>
                        <TH>PROGRAMS, PROJECTS, ACTIVITIES</TH>
                        <TH>PERFORMANCE INDICATORS</TH>
                        <TH>TARGET NUMBER</TH>
                        <TH>SUCCESS INDICATORS (TARGETS + MEASURES)</TH>
                        <TH>INDIVIDUAL ACCOUNTABLE</TH>
                        <TH>ACTUAL ACCOMPLISHMENTS NUMBER</TH>
                        <TH>ACTUAL ACCOMPLISHMENTS</TH>
                        <TH colspan="4" class="divide-x-2 divide-gray-300">
                            RATING
                            <TH>Q</TH>
                            <TH>T</TH>
                            <TH>E</TH>
                            <TH>AVE</TH>
                        </TH>
                        <TH>REMARK</TH>
                        <TH>LINK TO EVIDENCE</TH>
                        <TH>PMT REMARK</TH>
                        <TH>ACTION</TH>
                    </TableHead>
                    <TableHead>
                        <TH colspan="12">
                            CORE FUNCTIONS (75%) RESEARCH AND EXTENSION
                        </TH>
                    </TableHead>
                    <TableHead>
                        <TH colspan="12">
                            Development Goal 1: Challenge Innovation by
                            Expanding Academic and Research Programs
                        </TH>
                    </TableHead>
                    <TableHead>
                        <TH colspan="12">
                            Objective 2. (Research). Objective 2. (Research) To
                            Enchance Research Productivity Contributing To
                            Sustaianable Development
                        </TH>
                    </TableHead>

                    <TableBody v-for="target in targets[75]">
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
                            <TD>{{ sub_target.description }}</TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                        </tr>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4">SUBRATING: </TD>
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>

                    <TableHead>
                        <TH colspan="12"> STRATEGIC FUNCTIONS (15%) </TH>
                    </TableHead>

                    <TableBody v-for="target in targets[15]">
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
                            <TD>{{ sub_target.description }}</TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                        </tr>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4">SUBRATING: </TD>
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>

                    <TableHead>
                        <TH colspan="12"> STRATEGIC FUNCTIONS (10%) </TH>
                    </TableHead>

                    <TableBody v-for="target in targets[10]">
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
                            <TD>{{ sub_target.description }}</TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                            <TD></TD>
                        </tr>
                    </TableBody>

                    <TableBody>
                        <tr class="divide-x divide-gray-300">
                            <TD colspan="7"></TD>
                            <TD colspan="4">SUBRATING: </TD>
                            <TD colspan="4"></TD>
                        </tr>
                    </TableBody>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4">Core: </TD>
                        <TD colspan="4"></TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4">Strategic: </TD>
                        <TD colspan="4"></TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4">Support: </TD>
                        <TD colspan="4"></TD>
                    </tr>
                    <tr class="divide-x divide-gray-300">
                        <TD colspan="7"></TD>
                        <TD colspan="4">Final Ave: </TD>
                        <TD colspan="4"></TD>
                    </tr>
                </Table>
            </DivFlexCol>

            <DivFlexCenter class="justify-between">
                <DivFlexCol class="gap-1 w-full">
                    <SpanXS>Name and Signature of Ratee:</SpanXS>
                    <SpanXS>Position:</SpanXS>
                    <SpanXS>Date:</SpanXS>
                </DivFlexCol>
                <DivFlexCol class="gap-1 w-full">
                    <SpanXS>Final Rating by:</SpanXS>
                    <SpanXS>Position:</SpanXS>
                    <SpanXS>Date:</SpanXS>
                </DivFlexCol>
            </DivFlexCenter>
        </DivFlexCol>
    </MainLayout>
</template>
