<script setup>
import { router } from "@inertiajs/vue3";
import { watch, ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import useUpdate from "@/Composables/useUpdate";

const { targets, offices, filters, users } = defineProps({
    targets: {
        type: Object,
        required: true,
    },
    offices: {
        type: Object,
        required: false,
    },
    filters: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: false,
    },
});
const office = ref(
    offices.length > 0 ? filters.office ?? offices[0].value.toString() : null
);
const user = ref(
    users.length > 0 ? filters.user ?? users[0].value.toString() : null
);

watch(office, (value) => {
    router.get(route("tasks.index"), {
        office: value,
        user: user.value,
    });
});

watch(user, (value) => {
    router.get(route("tasks.index"), {
        office: null,
        user: value,
    });
});

const form = useForm({
    user_task_id: null,
    target_number: null,
    success_indicator: null,
    individual_accountable: null,
    actual_accomplishments: null,
    actual_accomplishments_number: null,
    q: null,
    t: null,
    e: null,
    remark: null,
    link_to_evidence: null,
    pmt_remark: null,
});
const isEditModalVisible = ref(false);
const openEditModal = (id) => {
    form.user_task_id = id;
    isEditModalVisible.value = true;
};

watch(
    () => form.user_task_id,
    (value) => {
        if (!value) return;

        axios
            .get(route("user-tasks.show", value))
            .then((res) => {
                const {
                    actual_accomplishments,
                    actual_accomplishments_number,
                    individual_accountable,
                    link_to_evidence,
                    pmt_remark,
                    q,
                    t,
                    e,
                    remark,
                    success_indicator,
                    target_number,
                } = res.data;

                form.target_number = target_number;
                form.success_indicator = success_indicator;
                form.individual_accountable = individual_accountable;
                form.actual_accomplishments = actual_accomplishments;
                form.actual_accomplishments_number =
                    actual_accomplishments_number;
                form.q = q;
                form.t = t;
                form.e = e;
                form.remark = remark;
                form.link_to_evidence = link_to_evidence;
                form.pmt_remark = pmt_remark;
            })
            .catch((e) => console.log(e));
    }
);

const getCurrentTaskUpdateRoute = () => {
    return route("user-tasks.update", form.user_task_id);
};

const { update } = useUpdate(form, getCurrentTaskUpdateRoute, "Task");

const updateTask = async () => {
    const result = await update();
    if (result) {
        isEditModalVisible.value = false;
        form.reset();
    }
};
</script>
<template>
    <Dialog
        v-model:visible="isEditModalVisible"
        modal
        header="Update Details"
        :style="{ width: '25rem' }"
    >
        <FormInput
            label="TARGET NUMBER"
            :errorMessage="form.errors.target_number"
        >
            <Input v-model="form.target_number" />
        </FormInput>
        <FormInput
            label="SUCCESS INDICATORS (TARGETS + MEASURES)"
            :errorMessage="form.errors.success_indicator"
        >
            <Input v-model="form.success_indicator" />
        </FormInput>
        <FormInput
            label="INDIVIDUAL ACCOUNTABLE"
            :errorMessage="form.errors.individual_accountable"
        >
            <Input v-model="form.individual_accountable" />
        </FormInput>
        <FormInput
            label="ACTUAL ACCOMPLISHMENTS NUMBER"
            :errorMessage="form.errors.actual_accomplishments_number"
        >
            <Input v-model="form.actual_accomplishments_number" />
        </FormInput>
        <FormInput
            label="ACTUAL ACCOMPLISHMENTS"
            :errorMessage="form.errors.actual_accomplishments"
        >
            <Input v-model="form.actual_accomplishments" />
        </FormInput>
        <FormInput label="Q" :errorMessage="form.errors.q">
            <Input v-model="form.q" />
        </FormInput>
        <FormInput label="T" :errorMessage="form.errors.t">
            <Input v-model="form.t" />
        </FormInput>
        <FormInput label="E" :errorMessage="form.errors.e">
            <Input v-model="form.e" />
        </FormInput>
        <FormInput label="Remark" :errorMessage="form.errors.remark">
            <Input v-model="form.remark" />
        </FormInput>
        <FormInput
            label="LINK TO EVIDENCE"
            :errorMessage="form.errors.link_to_evidence"
        >
            <Input v-model="form.link_to_evidence" />
        </FormInput>
        <FormInput label="PMT REMARK" :errorMessage="form.errors.pmt_remark">
            <Input v-model="form.pmt_remark" />
        </FormInput>
        <DivFlexCenter class="justify-end">
            <Button @click="updateTask" class="text-white">Update</Button>
        </DivFlexCenter>
    </Dialog>
    <MainLayout>
        <DivFlexCenter class="gap-2">
            <Select v-if="users.length > 0" v-model="user">
                <SelectTrigger>
                    <SelectValue placeholder="Select a user" />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectLabel>Users</SelectLabel>
                        <SelectItem
                            v-for="user in users"
                            :value="user.value.toString()"
                        >
                            {{ user.label }}
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>

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
        </DivFlexCenter>

        <DivFlexCol class="gap-5">
            <!-- <DivFlexCol class="items-center justify-center gap-3">
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
            </DivFlexCenter> -->

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
                            <TD v-for="user_task in sub_target.user_tasks">{{
                                user_task
                            }}</TD>

                            <TD>
                                <EditButton
                                    @click="
                                        openEditModal(sub_target.user_task_id)
                                    "
                                />
                            </TD>
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
                            <TD v-for="user_task in sub_target.user_tasks">{{
                                user_task
                            }}</TD>

                            <TD>
                                <EditButton
                                    @click="
                                        openEditModal(sub_target.user_task_id)
                                    "
                                />
                            </TD>
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
                            <TD v-for="user_task in sub_target.user_tasks">{{
                                user_task
                            }}</TD>

                            <TD>
                                <EditButton
                                    @click="
                                        openEditModal(sub_target.user_task_id)
                                    "
                                />
                            </TD>
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

            <!-- <DivFlexCenter class="justify-between">
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
            </DivFlexCenter> -->
        </DivFlexCol>
    </MainLayout>
</template>
